<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function categoryIndex()
    {
        $user = User::find(Auth::user()->id);
        $categories = ProductCategory::all();

        if ($user->isAdmin()) {
            return view('admin.menus.category.index', compact('categories'));
        } else {

            if ($user->store()->count() == 0) {
                return redirect()->route('food_seller.store');
            }

            return view('food_seller.menus.category.index', compact('categories'));
        }
    }

    public function showCategoryCreateForm()
    {
        $category = null;
        return view('admin.menus.category.edit', compact('category'));
    }

    public function showCategoryEditForm($id)
    {
        $category = ProductCategory::find($id);
        return view('admin.menus.category.edit', compact('category'));
    }

    public function saveCategory(Request $request)
    {
        //dd($request);

        $request->validate([
            'name' => 'required',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description ? $request->description : '',
        ]);

        return redirect()->route('admin.menus.category')->with('swal-success', 'Product Category Save Successful.');
    }

    public function updateCategory(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required',
        ]);

        $category = ProductCategory::find($request->id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.menus.category')->with('swal-success', 'Category update successful.');
    }

    public function deleteCategory(Request $request)
    {
        ProductCategory::destroy($request->id);
        return response()->json('Category delete successful.');
    }

    public function productIndex()
    {

        $user = User::find(Auth::user()->id);

        if ($user->isAdmin()) {
            $products = Product::all();

            return view('admin.menus.list.index', compact('products'));
        } else {

            if ($user->store()->count() == 0) {
                return redirect()->route('food_seller.store');
            }

            $products = $user->store->products;

            return view('food_seller.menus.product.index', compact('products'));
        }
    }

    public function productDetails(Request $request){
        $product = Product::find($request->product_id);

        return view('admin.menus.list.details', compact('product'));
    }

    public function showProductCreateForm()
    {
        $product = null;
        $categories = ProductCategory::all();
        return view('food_seller.menus.product.edit', compact('product', 'categories'));
    }

    public function saveProduct(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'category_id' => 'required|integer|gt:0',
                'barcode' => 'nullable|numeric',
                'price' => 'required|regex:/^[0-9]*(\.[0-9]{0,2})?$/',
                'optionName.*' => 'required',
                'optionDetail.*.*' => 'required',
                'additionalPrice.*.*' => 'numeric',
            ],
            [
                'category_id.gt' => 'The category field need to choose a category.',
                'optionName.*.required' => 'The optionName field is required.',
                'optionDetail.*.*.required' => 'The optionDetail field is required.',
                'additionalPrice.*.*.numeric' => 'The additional price field must be a number.',
            ]
        );

        $user = User::find(Auth::user()->id);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'media_path' => $request->image_path ? substr(parse_url($request->image_path, PHP_URL_PATH), 1) : null,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'status' => $request->status == 'on' ? true : false,
            'store_id' => $user->store->id,
            'category_id' => $request->category_id,
        ]);

        if ($request->optionName) {
            foreach ($request->optionName as $key => $value) {
                $option = $product->productOptions()->create([
                    'name' => $value,
                    'description' => $request->optionDescription[$key],
                ]);

                foreach ($request->optionDetail[$key] as $key1 => $value1) {
                    $option->optionDetails()->create([
                        'name' => $value1,
                        'extra_price' => $request->additionalPrice[$key][$key1],
                    ]);
                }
            }
        }

        return redirect()->route('food_seller.menus.product')->with('swal-success', 'Product info save successful.');
    }

    public function showProductEditForm($id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::all();
        return view('food_seller.menus.product.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request){

        $request->validate(
            [
                'name' => 'required',
                'category_id' => 'required|integer|gt:0',
                'barcode' => 'nullable|numeric',
                'price' => 'required|regex:/^[0-9]*(\.[0-9]{0,2})?$/',
                'optionName.*' => 'required',
                'optionDetail.*.*' => 'required',
                'additionalPrice.*.*' => 'numeric',
            ],
            [
                'category_id.gt' => 'The category field need to choose a category.',
                'optionName.*.required' => 'The optionName field is required.',
                'optionDetail.*.*.required' => 'The optionDetail field is required.',
                'additionalPrice.*.*.numeric' => 'The additional price field must be a number.',
            ]
        );

        //dd($request);

        $product = Product::find($request->productId);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'media_path' => $request->image_path ? substr(parse_url($request->image_path, PHP_URL_PATH), 1) : null,
            'description' => $request->description,
            'status' => $request->status == 'on' ? true : false,
        ]);

        $optionsId = $request->optionId ? $request->optionId : array();
        $optionDetailId = $request->optionDetailId ? $request->optionDetailId : array();

        // check if user has input any option name,
        // update or create the options and optionDetails which has record or no record first,
        // then delete the options and optionDetails which id not inside optionsId and optionDetailId,
        // else will delete all the options and optionDetails related to the product
        if($request->optionName){
            for($i = 0; $i < count($request->optionName); $i++){

                if(isset($optionsId[$i])){

                    //update option
                    $product->productOptions()->find($optionsId[$i])->update([
                        'name' => $request->optionName[$i],
                        'description' => $request->optionDescription[$i],
                    ]);

                    $option = $product->productOptions()->find($optionsId[$i]);

                    //update or create new option details
                    for($j = 0; $j < count($request->optionDetail[$i]); $j++){
                        if(isset($optionDetailId[$i][$j])){

                            // update optionDetail
                            $option->optionDetails()->find($optionDetailId[$i][$j])->update([
                                'name' => $request->optionDetail[$i][$j],
                                'extra_price' => $request->additionalPrice[$i][$j],
                            ]);
                        } else {

                            // create new optionDetail
                            $detail = $option->optionDetails()->create([
                                'name' => $request->optionDetail[$i][$j],
                                'extra_price' => $request->additionalPrice[$i][$j],
                            ]);

                            array_push($optionDetailId[$i], $detail->id);
                        }
                    }

                } else {

                    // create new option
                    $newOption = $product->productOptions()->create([
                        'name' => $request->optionName[$i],
                        'description' => $request->optionDescription[$i],
                    ]);

                    // create new optionDetail
                    if($request->optionDetail[$i]){

                        foreach($request->optionDetail[$i] as $key => $value){
                            $newOptionDetail = $newOption->optionDetails()->create([
                                'name' => $value,
                                'extra_price' => $request->additionalPrice[$i][$key],
                            ]);

                            if(!array_key_exists($i, $optionDetailId)){
                                $optionDetailId[$i] = array();
                            }

                            array_push($optionDetailId[$i], $newOptionDetail->id);
                        }

                    }

                    array_push($optionsId, $newOption->id);
                }

            }

            // delete the record not in $optionsId and $optionDetailId
            $productOptions = $product->productOptions()->get();
            for($i = 0; $i < count($optionDetailId); $i++){
                $productOptions[$i]->optionDetails()->whereNotIn('id', $optionDetailId[$i])->delete();
            }

            $options = $product->productOptions()->whereNotIn('id', $optionsId)->get();
            foreach($options as $option){
                $option->optionDetails()->delete();
                $option->delete();
            }

        } else {
            // delete all options and optionDetails
            $options = $product->productOptions()->get();

            foreach ($options as $option) {
                $option->optionDetails()->delete();
                $option->delete();
            }
        }

        return redirect()->route('food_seller.menus.product')->with('swal-success', 'Product info update successful.');
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->id);
        $options = $product->productOptions()->get();

        foreach ($options as $option) {
            $option->optionDetails()->delete();
            $option->delete();
        }

        $product->delete();

        return response()->json('Product delete successful.');
    }
}

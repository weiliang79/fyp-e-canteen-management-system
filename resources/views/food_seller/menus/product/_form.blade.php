<ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
      <li class="nav-items">
            <a class="nav-link active" id="pills-details-tab" data-bs-toggle="pill" data-bs-target="#pills-details" role="tab" aria-controls="pills-details" aria-selected="true" href="#">Details</a>
      </li>
      <li class="nav-items">
            <a class="nav-link" id="pills-options-tab" data-bs-toggle="pill" data-bs-target="#pills-options" role="tab" aria-controls="pills-options" aria-selected="false" href="#">Options</a>
      </li>
</ul>

<div class="tab-content" id="tabContent">
      <div class="tab-pane fade show active" id="pills-details" role="tabpanel" aria-labelledby="pilla-details-tab">

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Product Name') }}</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-bowl-food fa-fw"></i>
                              </div>

                              @if($product)
                              <input type="hidden" name="productId" value="{{ $product->id }}">
                              @endif
                              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product !== null ? $product->name : '') }}" placeholder="Product Name">

                              @error('name')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror

                        </div>
                  </div>
            </div>

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Category') }}</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                              </div>

                              <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="">
                                    <option value="0">Select a category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product !== null ? $product->category_id : '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                              </select>

                              @error('category_id')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                        </div>
                  </div>
            </div>

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Barcode') }}</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-barcode fa-fw"></i>
                              </div>

                              <input type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ old('barcode', $product !== null ? $product->barcode : '') }}" placeholder="Barcode">

                              @error('barcode')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror

                        </div>
                  </div>
            </div>

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Price') }}({{ config('payment.currency_symbol') }})</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-dollar-sign fa-fw"></i>
                              </div>

                              <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product !== null ? $product->price : '') }}" placeholder="Price">

                              @error('price')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror

                        </div>
                  </div>
            </div>

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Image') }}</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-image fa-fw"></i>
                              </div>

                              <input id="image_path" class="form-control @error('image_path') is-invalid @enderror" type="text" name="image_path" value="{{ old('image_path', $product !== null ? ($product->media_path !== null ? Request::root() . '/' . $product->media_path : '') : '') }}">
                              <button class="btn btn-primary" id="lfm" data-input="image_path" data-preview="holder">Choose Image</button>

                              @error('image_path')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror

                        </div>
                  </div>
            </div>

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Status') }}</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-circle-check fa-fw"></i>
                              </div>

                              <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                    <input type="checkbox" class="form-check-input" role="switch" id="statusSwitch" name="status" {{ old('status', $product !== null ? ($product->status == true ? 'on' : '') : '') == 'on' ? 'checked' : '' }}>
                              </div>

                              @error('status')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror

                        </div>
                  </div>
            </div>

            <div class="row mb-3">
                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>

                  <div class="col-md-8">
                        <div class="input-group">
                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                    <i class="fa-solid fa-quote-right fa-fw"></i>
                              </div>

                              <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ old('description', $product !== null ? $product->description : '') }}</textarea>

                              @error('name')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror

                        </div>
                  </div>
            </div>

      </div>

      <div class="tab-pane fade" id="pills-options" role="tabpanel" aria-labelledby="pills-options-tab">

            <div id="options">
                  <?php
                  $optionsId = session()->getOldInput('optionId');
                  $options = session()->getOldInput('optionName');
                  $descriptions = session()->getOldInput('optionDescription');
                  $optionDetailId = session()->getOldInput('optionDetailId');
                  $optionDetail = session()->getOldInput('optionDetail');
                  $additionalPrices = session()->getOldInput('additionalPrice');

                  if ($product !== null) {
                        if ($product->productOptions && $options === null) {
                              $count = 0;
                              foreach ($product->productOptions as $option) {
                                    echo '<div class="row mb-3 justify-content-center optionGroup">
                              <div class="col-md-10">
                                    <div class="card">
                                          <div class="card-header">
                                                <div class="row mb-3">
                                                      <label for="" class="col-md-3 col-form-label text-md-end">Option Name</label>
                  
                                                      <div class="col-md-8">
                                                            <div class="input-group">
                                                                  <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                        <i class="fa-solid fa-utensils fa-fw"></i>
                                                                  </div>
                  
                                                                  <input type="hidden" name="optionId[]" value="' . $option->id . '"> 
                                                                  <input class="form-control" type="text" name="optionName[]" placeholder="Option Name" value="' . $option->name . '">
                                                            </div>
                                                      </div>
                                                </div>
                  
                                                <div class="row mb-3">
                                                      <label for="" class="col-md-3 col-form-label text-md-end">Description</label>
                  
                                                      <div class="col-md-8">
                                                            <div class="input-group">
                                                                  <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                        <i class="fa-solid fa-quote-right fa-fw"></i>
                                                                  </div>
                  
                                                                  <textarea class="form-control") is-invalid @enderror" name="optionDescription[]" id="" cols="30" rows="3">' . $option->description . '</textarea>
                                                            </div>
                                                      </div>
                                                </div>
                  
                                                <div class="row">
                                                      <div class="col-md-8 offset-md-10">
                                                            <button type="button" class="btn btn-danger" onclick="delOptions(this);"><i class="fa-solid fa-minus"></i></button>
                                                      </div>
                                                </div>
                                          </div>
                  
                                          <div class="card-body">
                                                <div id="optionDetail' . $count . '">';

                                    foreach ($option->optionDetails as $detail) {
                                          if ($detail->name == 'None') {
                                                echo '<div class="row mb-3 justify-content-center optionDetailGroup">
                                                            <div class="col-md-10">
                                                                  <div class="card">
                                                                        <div class="card-body">
                  
                                                                              <div class="row mb-3">
                                                                                    <label for="" class=" col-md-3 col-form-label text-md-end">Option</label>
                  
                                                                                    <div class="col-md-8">
                                                                                          <div class="input-group">
                                                                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                                      <i class="fa-solid fa-wheat-awn-circle-exclamation fa-fw"></i>
                                                                                                </div>
                  
                                                                                                <input class="form-control" type="text" name="optionDetail" placeholder="Option" value="None" disabled>
                                                                                                <input type="hidden" name="optionDetailId[' . $count . '][]" value="' . $detail->id . '"> 
                                                                                                <input type="hidden" name="optionDetail[' . $count . '][]" value="None">
                                                                                          </div>
                                                                                    </div>
                                                                              </div>
                  
                                                                              <div class="row mb-3">
                                                                                    <label for="" class=" col-md-3 col-form-label text-md-end">Additional Price(' . Config::get('payment.currency_symbol') . ')</label>
                  
                                                                                    <div class="col-md-8">
                                                                                          <div class="input-group">
                                                                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                                      <i class="fa-solid fa-money-bill-wheat fa-fw"></i>
                                                                                                </div>
                  
                                                                                                <input class="form-control" type="text" name="additionalPrice" placeholder="Additional Price" value="0.00" disabled>
                                                                                                <input type="hidden" name="additionalPrice[' . $count . '][]" value="0.00">
                                                                                          </div>
                                                                                    </div>
                                                                              </div>
                  
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>';
                                          } else {
                                                echo '<div class="row mb-3 justify-content-center optionDetailGroup">
                                          <div class="col-md-10">
                                                <div class="card">
                                                      <div class="card-body">
                              
                                                            <div class="row mb-3">
                                                                  <label for="" class=" col-md-3 col-form-label text-md-end">Option</label>
                              
                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                    <i class="fa-solid fa-wheat-awn-circle-exclamation fa-fw"></i>
                                                                              </div>
                              
                                                                              <input type="hidden" name="optionDetailId[' . $count . '][]" value="' . $detail->id . '">
                                                                              <input class="form-control" type="text" name="optionDetail[' . $count . '][]" placeholder="Option" value="' . $detail->name . '">
                                                                        </div>
                                                                  </div>
                                                            </div>
                              
                                                            <div class="row mb-3">
                                                                  <label for="" class=" col-md-3 col-form-label text-md-end">Additional Price(' . Config::get('payment.currency_symbol') . ')</label>
                              
                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                    <i class="fa-solid fa-money-bill-wheat fa-fw"></i>
                                                                              </div>
                              
                                                                              <input class="form-control" type="text" name="additionalPrice[' . $count . '][]" placeholder="Additional Price" value="' . $detail->extra_price . '">
                                                                        </div>
                                                                  </div>
                                                            </div>
                              
                                                            <div class="row">
                                                                  <div class="col-md-8 offset-md-10">
                                                                        <button type="button" class="btn btn-danger" onclick="delOptionDetail(this);" data-count=""><i class="fa-solid fa-minus"></i></button>
                                                                  </div>
                                                            </div>
                              
                                                      </div>
                                                </div>
                                          </div>
                                    </div>';
                                          }
                                    }

                                    echo '</div>

                                                <div class="row mb-0">
                                                      <div class="col-md-8 offset-md-10">
                                                            <button type="button" class="btn btn-primary" onclick="addOptionDetail(this);" data-count="' . $count . '"><i class="fas fa-plus"></i></button>
                                                      </div>
                                                </div>
                  
                                          </div>
                                    </div>
                              </div>
                        </div>';
                                    $count++;
                              }
                        }
                  }

                  if ($options) {
                        foreach ($options as $key => $value) {
                              echo '<div class="row mb-3 justify-content-center optionGroup">
                                    <div class="col-md-10">
                                          <div class="card">
                                                <div class="card-header">
                                                      <div class="row mb-3">
                                                            <label for="" class="col-md-3 col-form-label text-md-end">Option Name</label>
                        
                                                            <div class="col-md-8">
                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                              <i class="fa-solid fa-utensils fa-fw"></i>
                                                                        </div>

                                                                        ';

                              if ($errors->has('optionName.' . strval($key))) {
                                    echo '<input class="form-control is-invalid" type="text" name="optionName[' . $key . ']" placeholder="Option Name">
                                                                              
                                          <span class="invalid-feedback" role="alert">
                                                <strong>' . $errors->first('optionName.' . strval($key)) . '</strong>
                                          </span>';
                              } else {
                                    echo '<input class="form-control" type="text" name="optionName[' . $key . ']" placeholder="Option Name" value="' . $value . '">';
                              }

                              if ($optionsId !== null) {
                                    if (array_key_exists($key, $optionsId)) {
                                          echo '<input type="hidden" name="optionNameId[' . $key . ']" value="' . $optionsId[$key] . '">';
                                    }
                              }

                              echo '</div>
                                                            </div>
                                                      </div>
                        
                                                      <div class="row mb-3">
                                                            <label for="" class="col-md-3 col-form-label text-md-end">Description</label>
                        
                                                            <div class="col-md-8">
                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                              <i class="fa-solid fa-quote-right fa-fw"></i>
                                                                        </div>
                        
                                                                        <textarea class="form-control" name="optionDescription[]" id="" cols="30" rows="3">' . $descriptions[$key] . '</textarea>
                                                                  </div>
                                                            </div>
                                                      </div>
                        
                                                      <div class="row">
                                                            <div class="col-md-8 offset-md-10">
                                                                  <button type="button" class="btn btn-danger" onclick="delOptions(this);"><i class="fa-solid fa-minus"></i></button>
                                                            </div>
                                                      </div>
                                                </div>
                        
                                                <div class="card-body">
                        
                                                      <div id="optionDetail' . $key . '">';

                              if ($optionDetail[$key]) {
                                    foreach ($optionDetail[$key] as $key1 => $value1) {
                                          if ($value1 == 'None') {
                                                echo '<div class="row mb-3 justify-content-center optionDetailGroup">
                                                <div class="col-md-10">
                                                      <div class="card">
                                                            <div class="card-body">
      
                                                                  <div class="row mb-3">
                                                                        <label for="" class=" col-md-3 col-form-label text-md-end">Option</label>
      
                                                                        <div class="col-md-8">
                                                                              <div class="input-group">
                                                                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                          <i class="fa-solid fa-wheat-awn-circle-exclamation fa-fw"></i>
                                                                                    </div>
      
                                                                                    <input class="form-control" type="text" name="optionDetail" placeholder="Option" value="None" disabled>
                                                                                    <input type="hidden" name="optionDetail[' . $key . '][]" value="None">';

                                                if ($optionDetailId !== null) {
                                                      if (array_key_exists($key1, $optionDetailId[$key])) {
                                                            echo '<input type="hidden" name="optionDetailId[' . $key . '][]" value="' . $optionDetailId[$key][$key1] . '">';
                                                      }
                                                }

                                                echo '</div>
                                                                        </div>
                                                                  </div>
      
                                                                  <div class="row mb-3">
                                                                        <label for="" class=" col-md-3 col-form-label text-md-end">Additional Price(' . Config::get('payment.currency_symbol') . ')</label>
      
                                                                        <div class="col-md-8">
                                                                              <div class="input-group">
                                                                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                          <i class="fa-solid fa-money-bill-wheat fa-fw"></i>
                                                                                    </div>
      
                                                                                    <input class="form-control" type="text" name="additionalPrice" placeholder="Additional Price" value="0.00" disabled>
                                                                                    <input type="hidden" name="additionalPrice[' . $key . '][]" value="0.00">
                                                                              </div>
                                                                        </div>
                                                                  </div>
      
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>';
                                          } else {
                                                echo '<div class="row mb-3 justify-content-center optionDetailGroup">
                                          <div class="col-md-10">
                                                <div class="card">
                                                      <div class="card-body">
                              
                                                            <div class="row mb-3">
                                                                  <label for="" class=" col-md-3 col-form-label text-md-end">Option</label>
                              
                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                    <i class="fa-solid fa-wheat-awn-circle-exclamation fa-fw"></i>
                                                                              </div>';

                                                if ($errors->has('optionDetail.' . strval($key) . '.' . strval($key1))) {
                                                      echo '<input class="form-control is-invalid" type="text" name="optionDetail[' . $key . '][]" placeholder="Option">
                                                      
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>' . $errors->first('optionDetail.' . strval($key) . '.' . strval($key1)) . '</strong>
                                                      </span>';
                                                } else {
                                                      echo '<input class="form-control" type="text" name="optionDetail[' . $key . '][]" placeholder="Option" value="' . $value1 . '">';
                                                }

                                                if ($optionDetailId !== null) {
                                                      if (array_key_exists($key1, $optionDetailId[$key])) {
                                                            echo '<input type="hidden" name="optionDetailId[' . $key . '][]" value="' . $optionDetailId[$key][$key1] . '">';
                                                      }
                                                }

                                                echo '</div>
                                                                  </div>
                                                            </div>
                              
                                                            <div class="row mb-3">
                                                                  <label for="" class=" col-md-3 col-form-label text-md-end">Additional Price(' . Config::get('payment.currency_symbol') . ')</label>
                              
                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                    <i class="fa-solid fa-money-bill-wheat fa-fw"></i>
                                                                              </div>';

                                                if ($errors->has('additionalPrice.' . strval($key) . '.' . strval($key1))) {
                                                      echo '<input class="form-control is-invalid" type="text" name="additionalPrice[' . $key . '][]" placeholder="Additional Price">
                                                                                    
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                          <strong>' . $errors->first('additionalPrice.' . strval($key) . '.' . strval($key1)) . '</strong>
                                                                                    </span>';
                                                } else {
                                                      echo '<input class="form-control" type="text" name="additionalPrice[' . $key . '][]" placeholder="Additional Price" value="' . $additionalPrices[$key][$key1] . '">';
                                                }

                                                echo '</div>
                                                                  </div>
                                                            </div>
                              
                                                            <div class="row">
                                                                  <div class="col-md-8 offset-md-10">
                                                                        <button type="button" class="btn btn-danger" onclick="delOptionDetail(this);"><i class="fa-solid fa-minus"></i></button>
                                                                  </div>
                                                            </div>
                              
                                                      </div>
                                                </div>
                                          </div>
                                    </div>';
                                          }
                                    }
                              }

                              echo '</div>
                        
                                                      <div class="row mb-0">
                                                            <div class="col-md-8 offset-md-10">
                                                                  <button type="button" class="btn btn-primary" onclick="addOptionDetail(this);" data-count="' . $key . '"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                      </div>
                        
                                                </div>
                                          </div>
                                    </div>
                              </div>';
                        }
                  }
                  ?>
            </div>

            <div class="row mb-0">
                  <div class="col-md-8 offset-md-10">
                        <a href="#" class="btn btn-primary" onclick="addOptions(this);" data-init="{{ session()->getOldInput('optionName') ? count(session()->getOldInput('optionName')) : ($product !== null ? count($product->productOptions) : '0') }}"><i class="fa-solid fa-plus"></i></a>
                  </div>
            </div>

      </div>
</div>

<template id="options_templates">
      <div class="row mb-3 justify-content-center optionGroup">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header">
                              <div class="row mb-3">
                                    <label for="" class="col-md-3 col-form-label text-md-end">Option Name</label>

                                    <div class="col-md-8">
                                          <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                      <i class="fa-solid fa-utensils fa-fw"></i>
                                                </div>

                                                <input class="form-control @error('optionName') is-invalid @enderror" type="text" name="optionName[]" placeholder="Option Name">
                                          </div>
                                    </div>
                              </div>

                              <div class="row mb-3">
                                    <label for="" class="col-md-3 col-form-label text-md-end">Description</label>

                                    <div class="col-md-8">
                                          <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                      <i class="fa-solid fa-quote-right fa-fw"></i>
                                                </div>

                                                <textarea class="form-control @error('optionDescription') is-invalid @enderror" name="optionDescription[]" id="" cols="30" rows="3"></textarea>
                                          </div>
                                    </div>
                              </div>

                              <div class="row">
                                    <div class="col-md-8 offset-md-10">
                                          <button type="button" class="btn btn-danger" onclick="delOptions(this);"><i class="fa-solid fa-minus"></i></button>
                                    </div>
                              </div>
                        </div>

                        <div class="card-body">

                              <div id="optionDetail">
                                    <div class="row mb-3 justify-content-center optionDetailGroup">
                                          <div class="col-md-10">
                                                <div class="card">
                                                      <div class="card-body">

                                                            <div class="row mb-3">
                                                                  <label for="" class=" col-md-3 col-form-label text-md-end">Option</label>

                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                    <i class="fa-solid fa-wheat-awn-circle-exclamation fa-fw"></i>
                                                                              </div>

                                                                              <input class="form-control" type="text" name="optionDetail" placeholder="Option" value="None" disabled>
                                                                              <input type="hidden" name="optionDetail[][]" value="None">
                                                                        </div>
                                                                  </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                  <label for="" class=" col-md-3 col-form-label text-md-end">Additional Price({{ config('payment.currency_symbol') }})</label>

                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 6%;">
                                                                                    <i class="fa-solid fa-money-bill-wheat fa-fw"></i>
                                                                              </div>

                                                                              <input class="form-control" type="text" name="additionalPrice" placeholder="Additional Price" value="0.00" disabled>
                                                                              <input type="hidden" name="additionalPrice[][]" value="0.00">
                                                                        </div>
                                                                  </div>
                                                            </div>

                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                              <div class="row mb-0">
                                    <div class="col-md-8 offset-md-10">
                                          <button type="button" class="btn btn-primary" onclick="addOptionDetail(this);" data-count=""><i class="fas fa-plus"></i></button>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </div>
</template>

<template id="optionDetail_templates">
      <div class="row mb-3 justify-content-center optionDetailGroup">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-body">

                              <div class="row mb-3">
                                    <label for="" class=" col-md-3 col-form-label text-md-end">Option</label>

                                    <div class="col-md-8">
                                          <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                      <i class="fa-solid fa-wheat-awn-circle-exclamation fa-fw"></i>
                                                </div>

                                                <input class="form-control" type="text" name="optionDetail[][]" placeholder="Option">
                                          </div>
                                    </div>
                              </div>

                              <div class="row mb-3">
                                    <label for="" class=" col-md-3 col-form-label text-md-end">Additional Price({{ config('payment.currency_symbol') }})</label>

                                    <div class="col-md-8">
                                          <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                      <i class="fa-solid fa-money-bill-wheat fa-fw"></i>
                                                </div>

                                                <input class="form-control" type="text" name="additionalPrice[][]" placeholder="Additional Price">
                                          </div>
                                    </div>
                              </div>

                              <div class="row">
                                    <div class="col-md-8 offset-md-10">
                                          <button type="button" class="btn btn-danger" onclick="delOptionDetail(this);" data-count=""><i class="fa-solid fa-minus"></i></button>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </div>
</template>

<script>
      var optionCount = 0;

      function addOptions(item) {
            html = $("#options_templates").html();
            var data = $(item).data('init');
            if (data !== 0 && optionCount < data) {
                  optionCount = data;
            }

            html = html.replace("optionDetail", "optionDetail" + optionCount.toString());
            html = html.replace('optionName[]', 'optionName[' + optionCount + ']');
            html = html.replace('optionDescription[]', 'optionDescription[' + optionCount + ']');
            changedHtml = html.replace("data-count=\"\"", 'data-count="' + optionCount + '"');

            item = $('#options').append(changedHtml);
            optionCount++;
      }

      function delOptions(input) {
            $(input).parents('.optionGroup').remove();
      }

      function addOptionDetail(item) {
            var data = $(item).data('count');

            html = $('#optionDetail_templates').html();
            html = html.replace('optionDetail[][]', 'optionDetail[' + data + '][]');
            html = html.replace('additionalPrice[][]', 'additionalPrice[' + data + '][]');
            changedHtml = html.replace("data-count=\"\"", 'data-count="' + data + '"');

            item = $('#optionDetail' + data.toString()).append(changedHtml);
      }

      function delOptionDetail(item) {
            $(item).parents('.optionDetailGroup').remove();
      }
</script>
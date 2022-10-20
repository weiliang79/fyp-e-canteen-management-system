<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\POSSettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestTimeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\studentAuth\StudentLoginController;
use App\Http\Controllers\UserManagementController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\studentAuth;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\StudentProfileController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentDetail2c2p;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/information/{id}/{title}', [LandingController::class, 'information'])->name('landing.information');

//Auth::routes();       //laravel UI default routes

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// student login routes
Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentLoginController::class, 'login']);

//login routes
Route::get('/admin/login', [LoginController::class, 'showloginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);

//register routes
//Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//Route::post('/register', [RegisterController::class, 'register']);

//reset password routes
Route::get('/admin/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');

// student reset password routes
Route::get('/student/password/reset', [studentAuth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('student.password.request');
Route::post('/student/password/email', [studentAuth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('student.password.email');
Route::get('/student/password/reset/{token}', [studentAuth\ResetPasswordController::class, 'showResetForm'])->name('student.password.reset');
Route::post('/student/password/reset', [studentAuth\ResetPasswordController::class, 'reset'])->name('student.password.update');

//password confirmation routes
//Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
//Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

//email verification routes
//Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
//Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => ['auth:student']], function () {

    // profile
    Route::get('/student/profile', [StudentProfileController::class, 'index'])->name('student.profile');
    Route::post('/student/profile/update_profile', [StudentProfileController::class, 'updateProfile'])->name('student.profile.update_profile');
    Route::post('/student/profile/email_verify', [StudentProfileController::class, 'verifyEmail'])->name('student.profile.email_verify');
    Route::post('/student/profile/update_email', [StudentProfileController::class, 'updateEmail'])->name('student.profile.update_email');
    Route::post('/student/profile/update_password', [StudentProfileController::class, 'updatePassword'])->name('student.profile.update_password');
    Route::post('/student/profile/update_notify', [StudentProfileController::class, 'updateNotify'])->name('student.profile.update_notify');

    // menus
    Route::get('/menus', [StudentMenuController::class, 'index'])->name('student.menus');
    Route::post('/menus/get_food_options', [StudentMenuController::class, 'getProductOptions'])->name('student.menus.get_product_options');
    Route::post('/menus/add_cart', [StudentMenuController::class, 'addCart'])->name('student.menus.add_cart');
    Route::get('/menus/carts', [StudentMenuController::class, 'cartIndex'])->name('student.menus.cart');
    Route::post('/menus/carts/delete', [StudentMenuController::class, 'deleteCartItem'])->name('student.menus.cart.delete');
    Route::post('/menus/carts/create_order', [StudentMenuController::class, 'createOrder'])->name('student.menus.create_order');

    Route::group(['middleware' => ['isPaymentMaintenance', 'isAllPaymentEnabled', 'isOrderMatchStudent:student', 'isOrderCompleted']], function () {

        // checkout
        Route::get('/checkout/{order_id}', [CheckoutController::class, 'index'])->name('student.checkout');
        Route::post('/checkout/{order_id}/process', [CheckoutController::class, 'process'])->name('student.checkout.process');

        // checkout - 2c2p
        Route::group(['middleware' => ['is2c2pEnabled']], function () {
            Route::get('/checkout/{order_id}/2c2p/process', [CheckoutController::class, 'process2c2p'])->name('student.checkout.2c2p.process');
            Route::match(['get', 'post'], '/checkout/{order_id}/receive_payment_info', [CheckoutController::class, 'receivePaymentInfo'])->name('student.checkout.receive_payment_info');
        });

        // checkout - stripe
        Route::group(['middleware' => ['isStripeEnabled']], function () {
            Route::get('/checkout/{order_id}/stripe_payment', [CheckoutController::class, 'stripeCharge'])->name('student.checkout.stripe');
            Route::post('/checkout/{order_id}/stripe_payment/process', [CheckoutController::class, 'stripeProcess'])->name('student.checkout.stripe.process');
        });

    });

    // checkout - result
    Route::get('/checkout/{order_id}/success', [CheckoutController::class, 'paymentSuccess'])->name('student.checkout.success');
    Route::get('/checkout/{order_id}/failure', [CheckoutController::class, 'paymentFailure'])->name('student.checkout.failure');

    // order
    Route::get('/student/order', [OrderController::class, 'index'])->name('student.order');

    // student logout routes
    Route::get('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');
});

Route::group(['middleware' => ['auth']], function () {

    // admin route
    Route::group(['middleware' => ['can:isAdmin']], function () {

        // profile
        Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/admin/profile/update_name', [ProfileController::class, 'updateName'])->name('admin.profile.update_name');
        Route::post('/admin/profile/email_verify', [ProfileController::class, 'verifyEmail'])->name('admin.profile.email_verify');
        Route::post('/admin/profile/update_email', [ProfileController::class, 'updateEmail'])->name('admin.profile.update_email');
        Route::post('/admin/profile/update_password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update_password');

        Route::group(['middleware' => 'emailVerified'], function () {

            // home
            Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');

            // user management
            Route::get('/admin/user_management', [UserManagementController::class, 'index'])->name('admin.user_management');
            Route::get('/admin/user_management/create', [UserManagementController::class, 'showCreateForm'])->name('admin.user_management.create');
            Route::post('/admin/user_management/save', [UserManagementController::class, 'save'])->name('admin.user_management.save');
            Route::post('/admin/user_management/delete', [UserManagementController::class, 'delete'])->name('admin.user_management.delete');

            // user management - student
            Route::get('/admin/user_management/student/create', [UserManagementController::class, 'showStudentCreateForm'])->name('admin.user_management.student.create');
            Route::post('admin/user_management/student/save', [UserManagementController::class, 'saveStudent'])->name('admin.user_management.student.save');
            Route::get('/admin/user_management/student/{id}/edit', [UserManagementController::class, 'showStudentEditForm'])->name('admin.user_management.student.edit');
            Route::post('/admin/user_management/student/{id}/update', [UserManagementController::class, 'updateStudent'])->name('admin.user_management.student.update');
            Route::post('/admin/user_management/student/delete', [UserManagementController::class, 'deleteStudent'])->name('admin.user_management.student.delete');

            // user management - student - rest time
            Route::get('/admin/user_management/rest_time', [RestTimeController::class, 'index'])->name('admin.user_management.student.rest_time');
            Route::post('/admin/user_management/rest_time/update', [RestTimeController::class, 'update'])->name('admin.user_management.student.rest_time.update');

            // store
            Route::get('/admin/store', [StoreController::class, 'adminIndex'])->name('admin.store');
            Route::get('/admin/store/{store_id}/details', [StoreController::class, 'adminDetails'])->name('admin.store.details');

            // menus - category
            Route::get('/admin/menus/category', [MenuController::class, 'categoryIndex'])->name('admin.menus.category');
            Route::get('/admin/menus/category/create', [MenuController::class, 'showCategoryCreateForm'])->name('admin.menus.category.create');
            Route::post('/admin/menus/category/save', [MenuController::class, 'saveCategory'])->name('admin.menus.category.save');
            Route::get('/admin/menus/category/{id}/edit', [MenuController::class, 'showCategoryEditForm'])->name('admin.menus.category.edit');
            Route::post('/admin/menus/category/update', [MenuController::class, 'updateCategory'])->name('admin.menus.category.update');
            Route::post('/admin/menus/category/delete', [MenuController::class, 'deleteCategory'])->name('admin.menus.category.delete');

            // menus - product list
            Route::get('/admin/menus/list', [MenuController::class, 'productIndex'])->name('admin.menus.list');
            Route::get('/admin/menus/list/{product_id}/details', [MenuController::class, 'productDetails'])->name('admin.menus.list.details');

            // order
            Route::get('/admin/order', [OrderController::class, 'adminIndex'])->name('admin.order');
            Route::get('/admin/order/{order_id}/details', [OrderController::class, 'adminOrderDetails'])->name('admin.order.details');

            // payment - general
            Route::get('/admin/payment/general', [PaymentController::class, 'index'])->name('admin.payment.general');
            Route::post('/admin/payment/general/save', [PaymentController::class, 'saveGeneral'])->name('admin.payment.general.save');

            // payment - 2c2p
            Route::get('/admin/payment/2c2p', [PaymentController::class, 'index2c2p'])->name('admin.payment.2c2p');
            Route::post('/admin/payment/2c2p/save', [PaymentController::class, 'save2c2p'])->name('admin.payment.2c2p.save');

            // payment - stripe
            Route::get('/admin/payment/stripe', [PaymentController::class, 'indexStripe'])->name('admin.payment.stripe');
            Route::post('/admin/payment/stripe/save', [PaymentController::class, 'saveStripe'])->name('admin.payment.stripe.save');

            // design
            Route::get('/admin/design/general', [DesignController::class, 'generalIndex'])->name('admin.design.general');
            Route::post('/admin/design/general/update', [DesignController::class, 'updateGeneral'])->name('admin.design.general.update');
            Route::get('/admin/design/landing', [DesignController::class, 'landingIndex'])->name('admin.design.landing');
            Route::post('/admin/design/landing/update', [DesignController::class, 'landingUpdate'])->name('admin.design.landing.update');
            Route::get('/admin/design/information', [DesignController::class, 'informationIndex'])->name('admin.design.information');
            Route::get('/admin/design/information/create', [DesignController::class, 'showInformationCreateForm'])->name('admin.design.information.create');
            Route::post('/admin/design/information/store', [DesignController::class, 'storeInformation'])->name('admin.design.information.store');
            Route::get('/admin/design/information/{id}/edit', [DesignController::class, 'showInformationEditForm'])->name('admin.design.information.edit');
            Route::post('/admin/design/information/{id}/update', [DesignController::class, 'updateInformation'])->name('admin.design.information.update');

            // reports
            Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports');
            Route::get('/admin/reports/get_data', [ReportController::class, 'getData'])->name('admin.reports.get_data');

            // media manager
            Route::get('/admin/media_manager', [MediaController::class, 'index'])->name('admin.media_manager');

            // POS settings
            Route::get('/admin/pos_settings', [POSSettingController::class, 'index'])->name('admin.pos_settings');
            Route::post('/admin/pos_settings/store', [POSSettingController::class, 'store'])->name('admin.pos_settings.store');
        });
    });

    // food seller route
    Route::group(['middleware' => ['can:isFoodSeller']], function () {

        // profile
        Route::get('/food_seller/profile', [ProfileController::class, 'index'])->name('food_seller.profile');
        Route::post('/food_seller/profile/update_name', [ProfileController::class, 'updateName'])->name('food_seller.profile.update_name');
        Route::post('/food_seller/profile/email_verify', [ProfileController::class, 'verifyEmail'])->name('food_seller.profile.email_verify');
        Route::post('/food_seller/profile/update_email', [ProfileController::class, 'updateEmail'])->name('food_seller.profile.update_email');
        Route::post('/food_seller/profile/update_password', [ProfileController::class, 'updatePassword'])->name('food_seller.profile.update_password');

        Route::group(['middleware' => ['emailVerified']], function () {
            // home
            Route::get('/food_seller/home', [HomeController::class, 'index'])->name('food_seller.home');

            // store
            Route::get('/food_seller/store', [StoreController::class, 'index'])->name('food_seller.store');
            Route::get('/food_seller/store/edit', [StoreController::class, 'showEditForm'])->name('food_seller.store.edit');
            Route::post('/food_seller/store/save', [StoreController::class, 'save'])->name('food_seller.store.save');

            // menu - category
            Route::get('/food_seller/menus/category', [MenuController::class, 'categoryIndex'])->name('food_seller.menus.category');

            // menu - product
            Route::get('/food_seller/menus/product', [MenuController::class, 'productIndex'])->name('food_seller.menus.product');
            Route::get('/food_seller/menus/product/create', [MenuController::class, 'showProductCreateForm'])->name('food_seller.menus.product.create');
            Route::post('/food_seller/menus/product/save', [MenuController::class, 'saveProduct'])->name('food_seller.menus.product.save');
            Route::get('/food_seller/menus/product/{id}/edit', [MenuController::class, 'showProductEditForm'])->name('food_seller.menus.product.edit');
            Route::post('/food_seller/menus/product/update', [MenuController::class, 'updateProduct'])->name('food_seller.menus.product.update');
            Route::post('/food_seller/menus/product/delete', [MenuController::class, 'deleteProduct'])->name('food_seller.menus.product.delete');

            // orders
            Route::get('/food_seller/order', [OrderController::class, 'foodSellerIndex'])->name('food_seller.order');
            Route::get('/food_seller/order/{order_id}/details', [OrderController::class, 'foodSellerDetails'])->name('food_seller.order.details');

            // reports
            Route::get('/food_seller/reports', [ReportController::class, 'index'])->name('food_seller.reports');
            Route::get('/food_seller/reports/get_data', [ReportController::class, 'getData'])->name('food_seller.reports.get_data');

            // media manager
            Route::get('/food_seller/media_manager', [MediaController::class, 'index'])->name('food_seller.media_manager');
        });
    });

    //logout routes
    Route::get('/admin/logout', [LoginController::class, 'logout'])->name('logout');

    // LaravelFileManager defined routes
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});

Route::get('/test', function () {
    $order = Order::find(4);
    return new App\Mail\StudentOrderSuccessful($order);
});

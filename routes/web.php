<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Front\IndexController;
use App\Models\Category;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function() {
    //toutes les routes de l'admin seront définies ici...
    Route::match(['get', 'post'],   '/',[App\Http\Controllers\Admin\AdminController::class, 'login']);
    Route::group(['middleware' => ['admin']],function() {
        Route::get('dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
        Route::get('logout', [App\Http\Controllers\Admin\AdminController::class, 'logout']);
        Route::get('settings', [App\Http\Controllers\Admin\AdminController::class, 'settings']);
        Route::post('check-current-pwd', [App\Http\Controllers\Admin\AdminController::class, 'checkCurrentPassword']);
        Route::post('update-current-pwd', [App\Http\Controllers\Admin\AdminController::class, 'updateCurrentPassword']);
        Route::match(['get', 'post'], 'update-admin-details',[App\Http\Controllers\Admin\AdminController::class, 'updateAdminDetails']);

        Route::get('sections',[App\Http\Controllers\Admin\SectionController::class, 'sections']);
        Route::post('update-section-status',[App\Http\Controllers\Admin\SectionController::class, 'updateSectionStatus']);

        Route::get('categories',[App\Http\Controllers\Admin\CategoryController::class, 'categories']);
        Route::post('update-category-status',[App\Http\Controllers\Admin\CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}',[App\Http\Controllers\Admin\CategoryController::class, 'addEditCategory']);
        Route::post('append-categories-level',[App\Http\Controllers\Admin\CategoryController::class, 'appendCategoriesLevel']);
        Route::get('delete-category-image/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'deleteCategoryImage']);
        Route::get('delete-category/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'deleteCategory']);

        Route::get('produits',[App\Http\Controllers\Admin\ProductController::class, 'products']);
        Route::post('update-product-status',[App\Http\Controllers\Admin\ProductController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteProduct']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}',[App\Http\Controllers\Admin\ProductController::class, 'addEditProduct']);
        Route::get('delete-product-image/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteProductImage']);

        Route::match(['get', 'post'], 'add-attributes/{id}',[App\Http\Controllers\Admin\ProductController::class, 'addAttributes']);
        Route::post('edit-attributes/{id}',[App\Http\Controllers\Admin\ProductController::class, 'editAttributes']);
        Route::post('update-attribute-status',[App\Http\Controllers\Admin\ProductController::class, 'updateAttributeStatus']);
        Route::get('delete-attribute/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteAttribute']);

        Route::match(['get', 'post'], 'add-images/{id}',[App\Http\Controllers\Admin\ProductController::class, 'addImages']);
        Route::post('update-image-status',[App\Http\Controllers\Admin\ProductController::class, 'updateImageStatus']);
        Route::get('delete-image/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteImage']);

        Route::get('banners', [App\Http\Controllers\Admin\BannerController::class, 'banners']);
        Route::post('update-banner-status',[App\Http\Controllers\Admin\BannerController::class, 'updateBannerStatus']);
        Route::get('delete-banner/{id}',[App\Http\Controllers\Admin\BannerController::class, 'deleteBanner']);
        Route::match(['get', 'post'], 'add-edit-banner/{id?}',[App\Http\Controllers\Admin\BannerController::class, 'addEditBanner']);

        Route::get('coupons',[App\Http\Controllers\Admin\CouponController::class, 'coupons']);
        Route::post('update-coupon-status',[App\Http\Controllers\Admin\CouponController::class, 'updateCouponStatus']);
        Route::get('delete-coupon/{id}',[App\Http\Controllers\Admin\CouponController::class, 'deleteCoupon']);
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}',[App\Http\Controllers\Admin\CouponController::class, 'addEditCoupon']);

        Route::get('orders', [App\Http\Controllers\Admin\OrdersController::class, 'orders']);
        Route::get('orders/{id}', [App\Http\Controllers\Admin\OrdersController::class, 'orderDetails']);
        Route::post('update-order-status',[App\Http\Controllers\Admin\OrdersController::class, 'updateOrderStatus']);
        Route::get('view-order-invoice/{id}', [App\Http\Controllers\Admin\OrdersController::class, 'viewOrderInvoice']);
        Route::get('print-pdf-invoice/{id}', [App\Http\Controllers\Admin\OrdersController::class, 'printPdfInvoice']);

        Route::get('view-shipping-charges', [App\Http\Controllers\Admin\ShippingController::class, 'viewShippingCharges']);
        Route::match(['get', 'post'], 'edit-shipping-charges/{id?}',[App\Http\Controllers\Admin\ShippingController::class, 'editShippingCharges']);
        Route::post('update-shipping-status',[App\Http\Controllers\Admin\ShippingController::class, 'updateShippingStatus']);
    });

});

Route::namespace('front')->group(function(){
    Route::get('/', [App\Http\Controllers\Front\IndexController::class, 'index']);
        $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();

    foreach ($catUrls as $url) {
        Route::get('/'.$url, [App\Http\Controllers\Front\ProductsController::class, 'listing']);
    }

    Route::get('/product/{id}', [App\Http\Controllers\Front\ProductsController::class, 'detail']);

    Route::post('/get-product-price', [App\Http\Controllers\Front\ProductsController::class, 'getProductPrice']);

    Route::post('/add-to-cart',[App\Http\Controllers\Front\ProductsController::class, 'addToCart']);

    Route::get('/cart',[App\Http\Controllers\Front\ProductsController::class, 'cart']);

    Route::post('/update-cart-item-qty',[App\Http\Controllers\Front\ProductsController::class, 'updateCartItemQty']);

    Route::post('/delete-cart-item',[App\Http\Controllers\Front\ProductsController::class, 'deleteCartItem']);

    Route::get('/login-register',[App\Http\Controllers\Front\UsersController::class, 'loginRegister'])->name('login');

    Route::post('/login',[App\Http\Controllers\Front\UsersController::class, 'loginUser']);
    Route::post('/register',[App\Http\Controllers\Front\UsersController::class, 'registerUser']);
    Route::match(['get','post'],'/check-email',[App\Http\Controllers\Front\UsersController::class, 'checkEmail']);
    Route::get('/logout',[App\Http\Controllers\Front\UsersController::class, 'logoutUser']);
    Route::match(['get','post'],'/confirm/{code}',[App\Http\Controllers\Front\UsersController::class, 'confirmAccount']);

    Route::group(['middleware'=>['auth']],function(){
        Route::match(['get','post'],'/forgot-password',[App\Http\Controllers\Front\UsersController::class, 'forgotPassword']);
        Route::match(['get','post'],'/account',[App\Http\Controllers\Front\UsersController::class, 'account']);
        Route::post('/check-user-pwd',[App\Http\Controllers\Front\UsersController::class, 'checkUserPassword']);
        Route::post('/update-user-pwd',[App\Http\Controllers\Front\UsersController::class, 'updateUserPassword']);
        Route::post('/apply-coupon',[App\Http\Controllers\Front\ProductsController::class, 'applyCoupon']);
        Route::match(['get','post'],'/checkout',[App\Http\Controllers\Front\ProductsController::class, 'checkout']);
        Route::match(['get', 'post'], 'add-edit-delivery-address/{id?}',[App\Http\Controllers\Front\ProductsController::class, 'addEditDeliveryAddress']);
        Route::get('/delete-delivery-address/{id}',[App\Http\Controllers\Front\ProductsController::class, 'deleteDeliveryAddress']);
        Route::get('/thanks', [App\Http\Controllers\Front\ProductsController::class, 'thanks']);
        Route::get('/orders', [App\Http\Controllers\Front\OrdersController::class, 'orders']);
        Route::get('/orders/{id}', [App\Http\Controllers\Front\OrdersController::class, 'orderDetails']);
        Route::get('/paypal', [App\Http\Controllers\Front\PaypalController::class, 'paypal']);
    });


});

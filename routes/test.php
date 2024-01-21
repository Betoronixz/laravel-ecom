Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
        Route::get('/orders', 'orders')->name('admin.orders');
        Route::get('/add_product', 'add_product')->name('admin.add_product');
        Route::post('/add_product', 'insert_product')->name('admin.insert_product');
        Route::get('/edit_product/{id}', 'edit_product')->name('admin.edit_product');
        Route::post('/update_product/{id}', 'update_product')->name('admin.update_product');
        Route::get('/logout', [AdminLoginController::class, 'logout')->name('admin.logout');
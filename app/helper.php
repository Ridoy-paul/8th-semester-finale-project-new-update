<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Colors;
use App\Models\Variation;
use App\Models\ProductStocks;
use App\Models\Page;


function featured_categories() {
    $categories = Category::where(['is_menu_active'=>1, 'is_active'=>1])->orderBy('menu_position', 'ASC')->limit(8)->get();
    return $categories;
}

function all_cateegories() {
    $all_categories = Category::orderBy('title', 'ASC')->get(['title', 'id']);
    return $all_categories;

}

function business_info() {
    $business = App\Models\Setting::find(1);
    return $business;
}

function color_info($id) {
    $info = Colors::find($id);
    return $info;
}

function variation_info($id) {
    $info = Variation::find($id);
    return $info;
}

function single_variation_info($variant_id, $product_id) {
    $info = ProductStocks::where('variant', $variant_id)->where('product_id', $product_id)->where('is_active', 1)->get(['id', 'variant', 'variant_output']);
    return $info;
}

function variation_stock_info($id) {
    $info = ProductStocks::find($id);
    return $info;
}

function other_pages() {
    $info = Page::get(['id', 'name']);
    return $info;
}




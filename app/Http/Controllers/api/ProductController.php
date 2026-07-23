<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller {

    public function index() {
        $payload = Cache::rememberForever('key', function () {

            $products = Product::all();
            if(request()->has("search")) {
                $search = request()->get("search");
                $products = $products->filter(function($product) use ($search) {
                    return str_contains(strtolower($product->name), strtolower($search));
                });
            }

            if(request()->has("status") ){
                    $status = request()->get("status");
                    $products = $products->filter(function($product) use ($search) { return str_contains(strtolower($product->status), strtolower($status));
                });
            }

            if(request()->has("sort")) {
                $sort = request()->get("sort");
                $direction = request()->get("direction", "asc");

                if(!in_array($direction, ["asc", "desc"])) {
                    $direction ="asc";
                }

                $products = $products->sortBy($sort, SORT_REGULAR, $direction === "desc");
            }

            if(request()->has("page")) {
                $page = request()->get("page", 1);
                $perPage = request()->get("per_page", 15);

                $products = $products->forPage($page, $perPage);
            }
            return ProductResource::collection($products);

        });

        return response()->json($payload);
    }

    public function create(ProductResource $request) {
        $products = Product::create($request->validated());
        return response()->json($products, 200);

    }
    public function show($id) {
        $product = Product::find($id);
        return response()->json($product, 200);
    }
    public function delete($id) {
        $product = Product::find($id);
        uf($product) {
            $product->d
        }

    }
    public function update() {}

}



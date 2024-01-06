<?php

namespace App\Http\Controllers;

// ------- Laravel Packages ------- //
use Illuminate\Http\Request;

// ------- Laravel Models -------- //
use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {

            $page = $request->get('page') ?? 1;
            $perPage = $request->get('per_page') ?? 10;

            $products = Product::paginate($perPage, ['*'], 'page', $page);

            return response()->json($products);
        } catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e,
                'line_error' => $e->getLine(),
                'server_response' => 'error'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            'description' => $validatedData['description']
        ]);

        if ($request->hasFile('images')) {
            $images = [];

            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $images[] = [
                    'path' => $path,
                    'url' => asset('storage/' . $path)
                ];
            }
            // Save the image paths in the database
            $product->images()->createMany($images);
        }

        return response()->json(['message' => 'Product created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {

            // Apply keyword search
            $query = Product::query();

            $page = $request->get('page') ?? 1;
            $perPage = $request->get('per_page') ?? 10;
            $search = $request->input('search');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")->orWhere('description', 'LIKE', "%$search%");
                })->get();
            }

            // Apply category filter
            $category = $request->input('category');
            if ($category) {
                $query->where('category', $category);
            }

            $products = $query->paginate($perPage);

            return response()->json($products);
        } catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e,
                'line_error' => $e->getLine(),
                'server_response' => 'error'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {

        } catch (\Exception $e) {

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {

            $product_id = Product::find($id);

            if($request->hasFile('image'))
            {

            }

            $product_id->update([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'category' => $request->get('category'),
                'image' => $request->get('image'),
                'date_time' => $request->get('date_time')
            ]);

        } catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e,
                'line_error' => $e->getLine(),
                'server_response' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $product_id = Product::find($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product has been deleted',
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e,
                'line_error' => $e->getLine(),
                'server_response' => 'error'
            ]);
        }
    }
}

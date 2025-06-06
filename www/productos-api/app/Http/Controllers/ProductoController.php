<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProductoController extends Controller
{
    // Listar todos los productos (GET /api/productos)
    public function index(): JsonResponse
    {
        $productos = Producto::all();
        return response()->json($productos, 200);
    }

    // Crear un nuevo producto (POST /api/productos)
	public function store(Request $request): JsonResponse
	{
	    try {
	        $validated = $request->validate([
	            'nombre'      => 'required|string|max:255',
	            'descripcion' => 'nullable|string',
	            'precio'      => 'required|numeric|min:0',
	            'stock'       => 'required|integer|min:0',
	        ]);

	        $producto = Producto::create($validated);
	        return response()->json($producto, 201);

	    } catch (ValidationException $ve) {
	        return response()->json([
	            'error' => 'Error de validación',
	            'messages' => $ve->errors()
	        ], 422);

	    } catch (\Exception $e) {
	        return response()->json([
	            'error' => 'Error al crear producto',
	            'message' => $e->getMessage()
	        ], 500);
	    }
	}

    // Mostrar detalle de un producto (GET /api/productos/{id})
    public function show($id): JsonResponse
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto, 200);
    }

    // Actualizar producto completo (PUT /api/productos/{id})
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($validated);
        return response()->json($producto, 200);
    }

    // Actualizar producto parcial (PATCH /api/productos/{id})
    public function patch(Request $request, $id): JsonResponse
    {
        $producto = Producto::findOrFail($id);

        $rules = [
            'nombre'      => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|nullable|string',
            'precio'      => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
        ];
        $validated = $request->validate($rules);

        $producto->update($validated);
        return response()->json($producto, 200);
    }

    // Eliminar producto (DELETE /api/productos/{id})
    public function destroy($id): JsonResponse
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Responses;

use App\Models\Category;

class ApiGetPetResponse
{
    public int $id;
    public Category $category;
    public string $name;
    public string $status;

    public function __construct(int $id,int $categoryId ,string $categoryName,string $name, string $status)
    {
        $this->id = $id;
        $this->category = new Category($categoryId, $categoryName);
        $this->name = $name;
        $this->status = $status;
    }
}

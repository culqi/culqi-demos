<?php
namespace App\Services;

use App\Repositories\ProductsRepository;

class ProductsService
{
  private ProductsRepository $productsRepository;

  public function __construct(ProductsRepository $productsRepository)
  {
    $this->productsRepository = $productsRepository;
  }

  public function all(): array
  {
    return $this->productsRepository->all();
  }

  public function find(int $id): ?array
  {
    return $this->productsRepository->find($id);
  }
}
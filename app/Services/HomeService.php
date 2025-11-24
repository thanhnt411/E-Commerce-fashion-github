<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\HomeServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ContactRepository;
use App\Repositories\SlideRepository;

class HomeService implements HomeServiceInterface
{
    /**
     * Create a new class instance.
     */

    public function __construct(
        protected  CategoryRepository $categoryRepo,
        protected  SlideRepository $slideRepo,
        protected  ProductRepositoryInterface $productRepo,
        protected  ContactRepository $contactRepo
    ) {}

    public function getHomeData()
    {
        return [
            'categories' => $this->categoryRepo->getLatesCategory(10),
            'slides' => $this->slideRepo->getActiveStatus(3),
            'sproducts' => $this->productRepo->getSaleProduct(8),
            'fproducts' => $this->productRepo->getFeatureProduct(8),
        ];
    }

    public function saveContact(array $data)
    {
        return $this->contactRepo->create($data);
    }

    public function searchProduct($query)
    {
        return $this->productRepo->search($query);
    }
}

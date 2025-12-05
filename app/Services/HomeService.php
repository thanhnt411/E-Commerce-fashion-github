<?php

namespace App\Services;

use App\DTOs\ContactData;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\SlideRepositoryInterface;
use App\Interfaces\Services\HomeServiceInterface;
use App\Repositories\ContactRepository;

class HomeService implements HomeServiceInterface
{
    /**
     * Create a new class instance.
     */

    public function __construct(
        protected  CategoryRepositoryInterface $categoryRepo,
        protected  SlideRepositoryInterface $slideRepo,
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

    public function saveContact(ContactData $data)
    {
        return $this->contactRepo->create($data->toArray());
    }

    public function searchProduct($query)
    {
        return $this->productRepo->search($query);
    }
}

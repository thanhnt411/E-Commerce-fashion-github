<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SlideRepository;

class HomeService
{
    /**
     * Create a new class instance.
     */
    protected $categoryRepo, $slideRepo, $productRepo, $contactRepo;
    public function __construct(
        CategoryRepository $categoryRepo,
        SlideRepository $slideRepo,
        ProductRepository $productRepo,
        ContactRepository $contactRepo
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->slideRepo = $slideRepo;
        $this->productRepo = $productRepo;
        $this->contactRepo = $contactRepo;
    }

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

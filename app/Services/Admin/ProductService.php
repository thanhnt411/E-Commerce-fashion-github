<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Services\FileService;
use App\Interfaces\Services\Admin\ProductServiceInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;


class ProductService implements ProductServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected FileService $fileService,
        protected ProductRepositoryInterface $productRepo
    ) {}

    public function getLatestProduct()
    {
        return $this->productRepo->getLatestProduct();
    }

    public function selectCategory()
    {
        return $this->productRepo->selectCategory();
    }

    public function selectBrand()
    {
        return $this->productRepo->selectBrand();
    }

    public function storeProduct(array $data, $primaryImg, $galleryImg)
    {
        if ($primaryImg) {
            $data['image'] =  $this->fileService->upload($primaryImg, 'products');
        }

        if ($galleryImg) {
            $data['images'] =  $this->fileService->uploadMore((array) $galleryImg, 'products/thumbnail');
        }
        return $this->productRepo->create($data);
    }


    public function updateProduct(Product $product, array $data,  $primaryImg, $galleryImg)
    {
        if ($primaryImg) {
            $oldPrimaryImg = $product->image;
            $data['image'] = $this->fileService->upload($primaryImg, 'products');
        }

        if ($galleryImg) {
            $oldGalleryImg = $product->images;
            $data['images'] =  $this->fileService->uploadMore($galleryImg, 'products/thumbnail');
        }

        $updateProduct =  $this->productRepo->update($product, $data);

        if ($oldPrimaryImg) {
            $this->fileService->delete($oldPrimaryImg);
        }

        if (!empty($oldGalleryImg)) {
            foreach (explode(',', $oldGalleryImg) as $olFile) {
                $this->fileService->delete($olFile);
            }
        }
        return $updateProduct;
    }

    public function deleteProduct(Product $product)
    {
        $this->fileService->delete($product->image);
        foreach (explode(',', $product->images) as $olFile) {
            $this->fileService->delete($olFile);
        }
        return $this->productRepo->delete($product);
    }
}

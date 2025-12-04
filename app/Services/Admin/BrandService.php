<?php

namespace App\Services\Admin;

use App\Services\FileService;
use App\Interfaces\Services\Admin\BrandServiceInterface;
use App\Interfaces\Repositories\BrandRepositoryInterface;
use App\Models\Brand;

class BrandService implements BrandServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected FileService $fileService,
        protected BrandRepositoryInterface $brandRepo
    ) {
        //
    }

    public function getBrandIdDESC()
    {
        return $this->brandRepo->getIdDESC();
    }

    public function storeBrand(array $data, $imgFile)
    {
        if ($imgFile) {
            $data['image'] =  $this->fileService->upload($imgFile, 'brands');
        }
        return $this->brandRepo->create($data);
    }

    public function updateBrand(Brand $brand, array $data, $imgFile)
    {
        if ($imgFile) {
            $oldImg = $brand->image;
            $data['image'] = $this->fileService->upload($imgFile, 'brands');
        }
        $updateBrand =  $this->brandRepo->update($brand, $data);

        if ($oldImg) {
            $this->fileService->delete($oldImg);
        }
        return $updateBrand;
    }

    public function deleteBrand(Brand $brand)
    {
        $this->fileService->delete($brand->image);
        return $this->brandRepo->delete($brand);
    }
}

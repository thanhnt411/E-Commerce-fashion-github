# Laravel Architecture Overview

**Projcet**: E-commerce-fashion
**Date**: 04/11/2025
**Author**: thanhnt1

---

## 1.Tổng quan dự án

Dự án được xấy dựng bằng **Laravel 12** tuân theo cấu trúc **M-V-C**
Mục tiêu:Cho phép người dùng xem sản phẩm,theo vào giỏ hàng,thanh toán và quản lý đơn hàng

---

## 2. Cấu trúc thư mục chính

**app/**
|--Htpp/
| |--Controller
| |--Middlerware
| |--Request
|--Models/
**bootstrap/**
**config/**
**database/**
|--migrations/
| |--Các bảng user,brand,category,product,coupon,order,order_item,address,transaction,...
**public/**
**resources/**
|--css/
|--js/
|--views/
| |--admin
| |--auth
| |--layouts
| |--user
| |--các blade view
**routes/**
|--web.php

---

## 3. Luồng Request → Response

**VD:Lưu thông tin trong bảng category
**User ->request(StoreCategoryRequest)
->route(/admin/categories/store)
->Controller:(AdminController@store_categories)->Xử lý request và logic
->Validate(Trong StoreCategoryRequest)
->Models:Lưu thông tin vào DB
->Return view(respone)
->Respone browser
**Luồng chạy**:Request->Route->Controller->Validate->Models->Respone->Browser

---

## 4. Các thành phần chính

|#--**Thành phần**--#|#-----------**Vai trò**-----------#|#-------**Ví dụ**------#|
|-------Models-------|--------Tương tác với CSDL---------|--------Category--------|
|-----Controller-----|--Xử lý request,gọi model và view--|--CategoriesController--|
|--------Route-------|------Nhận request->điều hướng-----|--/admin/categories/store--|
|-----Middleware-----|--------Xác thực,phân quyền--------|------AuthAdmin.php-----|
|---View(**Blade**)--|---------Hiển thị dữ liệu----------|---category.blade.php---|

---

## 5. Database Schema (Tóm tắt)

|#---**Bảng**---#|#---------**Mô tả**----------#|#----------**Quan hệ**----------#|
|------users-----|---Lưu thông tin người dùng---|-----------hasManyOrder----------|
|--transactions--|--Lưu phương thức thanh toán--|----------belongToOrder----------|
|-----slides-----|------Lưu slide Homepage------|-------------None----------------|
|-----brands-----|-------Danh sách brand--------|---------hasManyProudct----------|
|---categories---|-----Danh sách categories-----|---------hasManyProudct----------|
|----products----|------Danh sách sản phẩm------|----belongTo Brand,Categories----|
|-----orders-----|----Đơn hàng của người dùng---|---belongToUser,hasManyOrderItem,|
|----------------|------------------------------|hasOneTransaction----------------|
|---order-items--|--Chi tiết sản phẩm trong đơn-|-----belongsToProduct,Orders-----|
|-----address----|----Lưu địa chỉ người dùng----|-------------None----------------|
|----contacts----|--Lưu phản hồi của người dùng-|-------------None----------------|
|----coupons-----|-----Mã giảm giá sản phẩm-----|-------------None----------------|

---

## 6. Vấn đề hiện tại (trước refactor)

-Controller xử lý quá nhiều nghiệp vụ->vi phạm nguyên tắc SRP
-Có nhiều đoạn code trùng lặp
-Tên fuction chưa hợp lý
-Route đang bị rối

---

## 7. Hướng cải thiện (sau refactor)

-Tách Repository để xử lý thao tác với database
-Tách Service để xứ lý logic
-Sửa lại tên cho đúng ngữ cảnh
-Đặt theo prefix cho route

---

## 8. Kết luận

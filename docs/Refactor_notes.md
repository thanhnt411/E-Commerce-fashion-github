# Refactor Notes - E-commerce-fashion

**Projcet**: E-commerce-fashion
**Date**: 05/11/2025
**Author**: thanhnt1

---

## 1. Mục tiêu refactor hôm nay

-Tách xử lý DB và logic khỏi controller(ShopController)

---

## 2. Thay đổi chính đã thực hiện

-Tạo Repository và Service
-Tách Repo và Service cho HomeController
-Đặt lại tên fuction
-Gom nhóm route theo prefix

---

## 3. Kết quả sau refactor

-Controller ko còn bị quá dài dòng
-Function thể hiện rõ nghĩa
-Route dẽ đọc hơn

---

## 4. Ghi chú / Lỗi phát sinh

-Nhầm luồng chạy->luồng chạy đúng(Request->Controller->Service->Repository->Model->Respone)

---

## 5. Kế hoạch tiếp theo

-Refactor User Controller và WishlishController

---

**Kết luận:**

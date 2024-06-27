<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\RoleManagement\PermissionCategory;

class PermissionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        PermissionCategory::factory()
//            ->count(5)
//            ->create();

        PermissionCategory::insert([
            [
                'id' => 1,
                'name'  => 'Dashboard',
                'slug'  => 'Dashboard',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 2,
                'name'  => 'Permission Management',
                'slug'  => 'permission-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 3,
                'name'  => 'Role Management',
                'slug'  => 'role-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 4,
                'name'  => 'Course Management',
                'slug'  => 'course-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 5,
                'name'  => 'Course Content Management',
                'slug'  => 'course-content-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 6,
                'name'  => 'Batch Exam Management',
                'slug'  => 'batch-exam-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 7,
                'name'  => 'Batch Exam Content Management',
                'slug'  => 'batch-exam-content-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 8,
                'name'  => 'Pdf Management',
                'slug'  => 'pdf-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 9,
                'name'  => 'Question Management',
                'slug'  => 'question-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 10,
                'name'  => 'Blog Management',
                'slug'  => 'blog-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 11,
                'name'  => 'Product Management',
                'slug'  => 'product-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 12,
                'name'  => 'Job Circular Management',
                'slug'  => 'job-circular-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 13,
                'name'  => 'Notice Management',
                'slug'  => 'notice-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 14,
                'name'  => 'Model Test Management',
                'slug'  => 'model-test-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 15,
                'name'  => 'Order Management',
                'slug'  => 'order-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 16,
                'name'  => 'User Management',
                'slug'  => 'user-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 17,
                'name'  => 'Payment Management',
                'slug'  => 'payment-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 18,
                'name'  => 'Page Management',
                'slug'  => 'page-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 19,
                'name'  => 'Contact Management',
                'slug'  => 'contact-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 20,
                'name'  => 'Advertisement Management',
                'slug'  => 'advertisement-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 21,
                'name'  => 'Gallery Management',
                'slug'  => 'gallery-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 22,
                'name'  => 'Information Management',
                'slug'  => 'information-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 23,
                'name'  => 'Affiliation Management',
                'slug'  => 'affiliation-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 24,
                'name'  => 'Notification Management',
                'slug'  => 'notification-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 25,
                'name'  => 'Enroll Management',
                'slug'  => 'enroll-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 26,
                'name'  => 'My Course Management',
                'slug'  => 'my-course-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 27,
                'name'  => 'My Exam Management',
                'slug'  => 'my-exam-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 28,
                'name'  => 'Module Access Management',
                'slug'  => 'module-access-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 29,
                'name'  => 'Site Management Module',
                'slug'  => 'site-management-module',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ], [
                'id' => 30,
                'name'  => 'Service Management Module',
                'slug'  => 'service-management-module',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ], [
                'id' => 31,
                'name'  => 'SEO Management Module',
                'slug'  => 'SEO-management-module',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ], [
                'id' => 32,
                'name'  => 'Accounts Management Module',
                'slug'  => 'Accounts-management-module',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
        ]);
    }
}

<?php 

return [
    'mc_customers' => [
        'name' => [
            'type' => 'text',
            'label' => 'Nama'
        ],
        'phone' => [
            'type' => 'text',
            'label' => 'No. HP'
        ],
        'address' => [
            'type' => 'text',
            'label' => 'Alamat'
        ],
    ],
    'mc_sections' => [
        'name' => [
            'type' => 'text',
            'label' => 'Nama'
        ]
    ],
    'mc_categories' => [
        'section_id' => [
            'type' => 'options-obj:mc_sections,id,name',
            'label' => 'Section'
        ],
        'name' => [
            'type' => 'text',
            'label' => 'Nama'
        ],
    ],
    'mc_products' => [
        'category_id' => [
            'type' => 'options-obj:mc_categories,id,name',
            'label' => 'Kategori'
        ],
        'target_id' => [
            'type' => 'options-obj:users,id,name',
            'label' => 'Tujuan'
        ],
        'name' => [
            'type' => 'text',
            'label' => 'Nama'
        ],
    ],
    'mc_orders' => [
        'customer_id' => [
            'type' => 'options-obj:mc_customers,id,name',
            'label' => 'Kustomer'
        ],
        'code' => [
            'type' => 'text',
            'label' => 'No. Pesanan'
        ],
        'status' => [
            'type' => 'text',
            'label' => 'Status'
        ],
    ],
    'mc_order_items' => [
        'code' => [
            'type' => 'text',
            'label' => 'No. Pesanan',
            'search' => 'mc_orders.code'
        ],
        'product_name' => [
            'type' => 'text',
            'label' => 'Produk',
            'search' => 'mc_products.name'
        ],
        'customer_name' => [
            'type' => 'text',
            'label' => 'Pelanggan',
            'search' => 'mc_customers.name'
        ],
        'target_id' => [
            'type' => 'options-obj:users,id,name',
            'label' => 'Asal',
        ],
        'table_name' => [
            'type' => 'text',
            'label' => 'No. Meja'
        ],
        'floor_name' => [
            'type' => 'text',
            'label' => 'Lantai'
        ],
        'qty' => [
            'label' => 'Jumlah',
            'type' => 'number'
        ],
        'status' => [
            'type' => 'text',
            'label' => 'Status'
        ]
    ]
];
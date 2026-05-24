<?php

return [
    // Nhóm đáng giá
    'nhom_ld' => [
        // Nhóm 1: Trưởng TT
        '1' => ['01'],
        // Nhóm 2: Chánh Văn phòng, Trưởng phòng
        '2' => ['04', '05'],
        // Nhóm 3: Trưởng Thuế cơ sở
        '3' => ['03']
    ],
    // Nhóm được đánh giá
    'nhom_nv' => [
        // Nhóm 1: Phó Trưởng TT; Trưởng TCS; Chánh Văn phòng; Trưởng phòng
        '1' => ['02', '03', '04', '05'],
        // Nhóm 2: Phó Chánh Văn phòng; Phó Trưởng phòng; Công chức; HĐLĐ thuộc phòng
        '2' => ['07', '08', '11', '12'],
        // Nhóm 3: Tổ trưởng; Phó Tổ trưởng; Công chức; HĐLĐ thuộc đơn vị
        '3' => ['06', '09', '10', '11', '12']
    ]
];

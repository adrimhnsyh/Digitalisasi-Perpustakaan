<?php

return [
    'loan_duration_days' => (int) env('LIBRARY_LOAN_DURATION_DAYS', 7),
    'loan_max_items' => (int) env('LIBRARY_LOAN_MAX_ITEMS', 2),
    'late_fee_per_day' => (int) env('LIBRARY_LATE_FEE_PER_DAY', 1000),
];

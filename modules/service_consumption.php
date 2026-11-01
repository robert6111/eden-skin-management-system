<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('services.manage');

$bid = current_branch_id();

function spa_menu_service_catalog(): array {
    return [
[
        'category' => 'Facial Treatments',
        'name' => 'Dermaplaning',
        'description' => 'Remove dead skin for smooth & radiant skin',
        'duration' => 45,
        'price' => 20000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Deep Cleansing Facial',
        'description' => 'Nourishing & refreshing treatment',
        'duration' => 60,
        'price' => 35000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Glow Facial',
        'description' => 'Deep cleansing for a healthy glow',
        'duration' => 60,
        'price' => 45000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Hydro Facial',
        'description' => 'Intense hydration for plump skin',
        'duration' => 75,
        'price' => 65000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Acne Control Facial',
        'description' => 'Targets acne, reduces inflammation & prevents breakouts',
        'duration' => 75,
        'price' => 65000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Dark Spot Facial',
        'description' => 'Targets dark spots & uneven tone',
        'duration' => 75,
        'price' => 65000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Brightening Facial',
        'description' => 'Evens skin tone, reduces dullness & boosts natural radiance',
        'duration' => 75,
        'price' => 65000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Chemical Peel Facial',
        'description' => 'Advanced exfoliation',
        'duration' => 60,
        'price' => 75000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Anti-Aging Collagen Facial',
        'description' => 'Collagen boost & firming',
        'duration' => 90,
        'price' => 100000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Skin Barrier Repair',
        'description' => 'Strengthens & restores the skin barrier, soothes and deeply nourishes',
        'duration' => 90,
        'price' => 100000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Glass Skin Facial',
        'description' => 'Intense hydration for a smooth, clear and glass-like glow',
        'duration' => 90,
        'price' => 150000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Microneedling',
        'description' => 'Skin renewal & collagen induction',
        'duration' => 120,
        'price' => 190000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Facial Treatments',
        'name' => 'Skin Tag Removal (Visunzua)',
        'description' => 'Price depends on size and quantity. Set final price at POS if needed.',
        'duration' => 60,
        'price' => 100000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Bikini Wax',
        'description' => 'Body waxing service',
        'duration' => 45,
        'price' => 30000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Underarm Wax',
        'description' => 'Body waxing service',
        'duration' => 30,
        'price' => 20000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Brazilian Wax',
        'description' => 'Body waxing service',
        'duration' => 60,
        'price' => 40000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Full Legs Wax',
        'description' => 'Body waxing service',
        'duration' => 60,
        'price' => 30000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Half Legs Wax',
        'description' => 'Body waxing service',
        'duration' => 45,
        'price' => 20000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Thighs Wax',
        'description' => 'Body waxing service',
        'duration' => 45,
        'price' => 40000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Chest Wax',
        'description' => 'Body waxing service',
        'duration' => 45,
        'price' => 30000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Waxing',
        'name' => 'Arms Wax',
        'description' => 'Body waxing service',
        'duration' => 45,
        'price' => 20000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Facial Wax',
        'name' => 'Eyebrows Wax',
        'description' => 'Facial waxing service',
        'duration' => 20,
        'price' => 10000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Facial Wax',
        'name' => 'Upper Lip Wax',
        'description' => 'Facial waxing service',
        'duration' => 15,
        'price' => 5000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Facial Wax',
        'name' => 'Chin Wax',
        'description' => 'Facial waxing service',
        'duration' => 15,
        'price' => 10000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Facial Wax',
        'name' => 'Full Face Wax',
        'description' => 'Facial waxing service',
        'duration' => 45,
        'price' => 25000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Body Facials',
        'name' => 'Armpit Facial',
        'description' => 'Targets dark underarms and helps improve uneven skin tone and texture',
        'duration' => 45,
        'price' => 35000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Body Facials',
        'name' => 'Bikini Facial',
        'description' => 'Helps reduce ingrown hairs, bumps and uneven skin tone',
        'duration' => 60,
        'price' => 45000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Body Facials',
        'name' => 'Chest Facial',
        'description' => 'Helps reduce chest acne, clogged pores and uneven skin texture',
        'duration' => 60,
        'price' => 55000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Body Facials',
        'name' => 'Back Facial',
        'description' => 'Deep cleansing treatment that helps reduce back acne, clogged pores and excess oil',
        'duration' => 75,
        'price' => 65000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 14,
        'continuation_message' => 'Please come back after 14 days for skin review/continuation.'
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Body Shaping & Tightening - Stomach Only',
        'description' => 'Slimming therapy for stomach only',
        'duration' => 45,
        'price' => 35000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Body Shaping & Tightening - Weekly Program (3 Sessions)',
        'description' => 'Three-session stomach shaping and tightening program',
        'duration' => 135,
        'price' => 100000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Body Shaping & Tightening - Monthly Program (12 Sessions)',
        'description' => 'Twelve-session stomach shaping and tightening program',
        'duration' => 540,
        'price' => 380000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Full Body Shaping - Single Session',
        'description' => 'Stomach, thighs and arms body shaping',
        'duration' => 75,
        'price' => 70000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Full Body Shaping - Weekly Program (3 Sessions)',
        'description' => 'Three-session full body shaping program',
        'duration' => 225,
        'price' => 200000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Full Body Shaping - Monthly Program (12 Sessions)',
        'description' => 'Twelve-session full body shaping program',
        'duration' => 900,
        'price' => 800000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Slim & Detox Heat Therapy - Stomach Only',
        'description' => 'Slim and detox heat therapy for stomach only',
        'duration' => 45,
        'price' => 50000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Slim & Detox Heat Therapy - Weekly Program (3 Sessions)',
        'description' => 'Three-session stomach slim and detox heat therapy program',
        'duration' => 135,
        'price' => 130000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Slim & Detox Heat Therapy - Monthly Program (12 Sessions)',
        'description' => 'Twelve-session stomach slim and detox heat therapy program',
        'duration' => 540,
        'price' => 500000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Full Body Slim & Detox Therapy - Single Session',
        'description' => 'Stomach, thighs and arms slim and detox therapy',
        'duration' => 90,
        'price' => 100000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Full Body Slim & Detox Therapy - Weekly Program (3 Sessions)',
        'description' => 'Three-session full body slim and detox therapy program',
        'duration' => 270,
        'price' => 280000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ],
[
        'category' => 'Slimming Therapy',
        'name' => 'Full Body Slim & Detox Therapy - Monthly Program (12 Sessions)',
        'description' => 'Twelve-session full body slim and detox therapy program',
        'duration' => 1080,
        'price' => 1100000,
        'commission_type' => 'percentage',
        'commission_value' => 15,
        'continuation_days' => 0,
        'continuation_message' => ''
    ]
    ];
}

function spa_consumption_catalog(): array {
    return [
    'Dermaplaning' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses the skin before blade work.'],
        ['product'=>'Dermaplaning Blade','category'=>'Skin Care Tools','brand'=>'BeautyPlus','unit'=>'piece','buying'=>1000,'selling'=>2500,'min'=>20,'qty'=>1.000,'why'=>'One blade used for safe dermaplaning.'],
        ['product'=>'Facial Toner','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>5.000,'why'=>'Balances skin after cleansing.'],
        ['product'=>'Soothing Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>250,'selling'=>500,'min'=>200,'qty'=>5.000,'why'=>'Calms skin after exfoliation.'],
        ['product'=>'Sunscreen','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>180,'selling'=>350,'min'=>300,'qty'=>5.000,'why'=>'Protects skin after treatment.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>4.000,'why'=>'Used for wiping/cleaning.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.']
    ],
    'Deep Cleansing Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Main cleansing product.'],
        ['product'=>'Exfoliating Scrub','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>200,'min'=>500,'qty'=>8.000,'why'=>'Removes dead skin and buildup.'],
        ['product'=>'Facial Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>250,'min'=>500,'qty'=>15.000,'why'=>'Nourishing facial mask.'],
        ['product'=>'Facial Toner','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>5.000,'why'=>'Balances skin.'],
        ['product'=>'Facial Moisturizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>500,'qty'=>5.000,'why'=>'Moisturizes after treatment.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Used throughout cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One disposable towel for the client.']
    ],
    'Glow Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses skin.'],
        ['product'=>'Glow Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>300,'selling'=>600,'min'=>200,'qty'=>5.000,'why'=>'Glow serum for radiance.'],
        ['product'=>'Vitamin C Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>350,'selling'=>700,'min'=>150,'qty'=>3.000,'why'=>'Vitamin C for bright glow.'],
        ['product'=>'Facial Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>250,'min'=>500,'qty'=>15.000,'why'=>'Facial mask.'],
        ['product'=>'Facial Moisturizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>500,'qty'=>5.000,'why'=>'Finishing moisturizer.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Hydro Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses skin.'],
        ['product'=>'Hydrating Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>280,'selling'=>600,'min'=>200,'qty'=>10.000,'why'=>'Hydrating serum.'],
        ['product'=>'Facial Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>250,'min'=>500,'qty'=>15.000,'why'=>'Hydration mask.'],
        ['product'=>'Facial Moisturizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>500,'qty'=>5.000,'why'=>'Locks moisture.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Acne Control Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleans acne-prone skin.'],
        ['product'=>'Acne Treatment Gel','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>550,'min'=>150,'qty'=>5.000,'why'=>'Targets acne and inflammation.'],
        ['product'=>'Clay Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>220,'min'=>300,'qty'=>15.000,'why'=>'Controls oil and clogged pores.'],
        ['product'=>'Facial Toner','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>5.000,'why'=>'Balances skin.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene during extraction/treatment.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Dark Spot Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses skin.'],
        ['product'=>'Dark Spot Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>350,'selling'=>750,'min'=>150,'qty'=>5.000,'why'=>'Targets dark spots.'],
        ['product'=>'Brightening Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>280,'min'=>300,'qty'=>15.000,'why'=>'Brightening mask.'],
        ['product'=>'Sunscreen','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>180,'selling'=>350,'min'=>300,'qty'=>5.000,'why'=>'Protects treated skin.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Brightening Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses skin.'],
        ['product'=>'Brightening Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>350,'selling'=>750,'min'=>150,'qty'=>5.000,'why'=>'Brightening serum.'],
        ['product'=>'Vitamin C Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>350,'selling'=>700,'min'=>150,'qty'=>3.000,'why'=>'Supports brightening.'],
        ['product'=>'Brightening Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>280,'min'=>300,'qty'=>15.000,'why'=>'Brightening mask.'],
        ['product'=>'Sunscreen','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>180,'selling'=>350,'min'=>300,'qty'=>5.000,'why'=>'Protects skin.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Chemical Peel Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Prepares the skin.'],
        ['product'=>'Chemical Peel Solution','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>500,'selling'=>1000,'min'=>150,'qty'=>5.000,'why'=>'Chemical peel solution.'],
        ['product'=>'Peel Neutralizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>200,'selling'=>450,'min'=>150,'qty'=>10.000,'why'=>'Stops/neutralizes peel.'],
        ['product'=>'Soothing Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>250,'selling'=>500,'min'=>200,'qty'=>5.000,'why'=>'Calms skin after peel.'],
        ['product'=>'Sunscreen','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>180,'selling'=>350,'min'=>300,'qty'=>5.000,'why'=>'Protects peeled skin.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>6.000,'why'=>'Application and wiping.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Protection when handling acids.']
    ],
    'Anti-Aging Collagen Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses skin.'],
        ['product'=>'Collagen Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'piece','buying'=>3000,'selling'=>6000,'min'=>20,'qty'=>1.000,'why'=>'One collagen mask.'],
        ['product'=>'Anti-Aging Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>450,'selling'=>900,'min'=>150,'qty'=>5.000,'why'=>'Anti-aging serum.'],
        ['product'=>'Facial Moisturizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>500,'qty'=>5.000,'why'=>'Finishing moisturizer.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Skin Barrier Repair' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Gentle cleansing.'],
        ['product'=>'Barrier Repair Cream','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>650,'min'=>200,'qty'=>10.000,'why'=>'Repairs and strengthens skin barrier.'],
        ['product'=>'Soothing Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>250,'selling'=>500,'min'=>200,'qty'=>5.000,'why'=>'Calms irritated skin.'],
        ['product'=>'Facial Moisturizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>500,'qty'=>5.000,'why'=>'Locks in moisture.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>6.000,'why'=>'Wiping and cleansing.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Glass Skin Facial' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Cleanses skin.'],
        ['product'=>'Hydrating Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>280,'selling'=>600,'min'=>200,'qty'=>10.000,'why'=>'Deep hydration.'],
        ['product'=>'Glass Skin Ampoule','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>450,'selling'=>900,'min'=>150,'qty'=>5.000,'why'=>'Glass skin finishing ampoule.'],
        ['product'=>'Hydrogel Mask','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'piece','buying'=>3500,'selling'=>7000,'min'=>20,'qty'=>1.000,'why'=>'Hydrogel mask.'],
        ['product'=>'Facial Moisturizer','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>500,'qty'=>5.000,'why'=>'Finishing moisturizer.'],
        ['product'=>'Sunscreen','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>180,'selling'=>350,'min'=>300,'qty'=>5.000,'why'=>'Protects skin.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Wiping and cleansing.']
    ],
    'Microneedling' => [
        ['product'=>'Facial Cleanser','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Pre-treatment cleansing.'],
        ['product'=>'Disinfectant Solution','category'=>'Consumables','brand'=>'CleanPro','unit'=>'ml','buying'=>80,'selling'=>150,'min'=>500,'qty'=>5.000,'why'=>'Disinfects treatment area.'],
        ['product'=>'Numbing Cream','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>400,'selling'=>800,'min'=>100,'qty'=>5.000,'why'=>'Numbing cream before needling.'],
        ['product'=>'Microneedling Cartridge','category'=>'Skin Care Tools','brand'=>'BeautyPlus','unit'=>'piece','buying'=>9000,'selling'=>18000,'min'=>10,'qty'=>1.000,'why'=>'One sterile cartridge.'],
        ['product'=>'Hydrating Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>280,'selling'=>600,'min'=>200,'qty'=>10.000,'why'=>'Serum used with/after needling.'],
        ['product'=>'Soothing Mask Sheet','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'piece','buying'=>2500,'selling'=>5000,'min'=>20,'qty'=>1.000,'why'=>'Calms skin after procedure.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Protection and hygiene.']
    ],
    'Skin Tag Removal (Visunzua)' => [
        ['product'=>'Disinfectant Solution','category'=>'Consumables','brand'=>'CleanPro','unit'=>'ml','buying'=>80,'selling'=>150,'min'=>500,'qty'=>5.000,'why'=>'Disinfects the skin.'],
        ['product'=>'Skin Tag Removal Tip','category'=>'Skin Care Tools','brand'=>'BeautyPlus','unit'=>'piece','buying'=>2500,'selling'=>5000,'min'=>20,'qty'=>1.000,'why'=>'Disposable removal tip/tool.'],
        ['product'=>'Antiseptic Cream','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>180,'selling'=>350,'min'=>100,'qty'=>5.000,'why'=>'After-care cream.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>6.000,'why'=>'Cleaning and wiping.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Protection and hygiene.']
    ],
    'Bikini Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>40.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>8.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>8.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Underarm Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>20.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>4.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>4.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.']
    ],
    'Brazilian Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>60.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>12.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>12.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Full Legs Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>80.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>16.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>16.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Half Legs Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>40.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>8.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>8.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Thighs Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>60.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>12.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>12.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Chest Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>50.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>10.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>10.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Arms Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>40.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>8.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Wax Strips','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>120,'selling'=>250,'min'=>100,'qty'=>8.000,'why'=>'Wax strips used during body waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One towel for the client.']
    ],
    'Eyebrows Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>5.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>2.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>5.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>4.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.']
    ],
    'Upper Lip Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>3.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>1.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>5.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>4.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.']
    ],
    'Chin Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>5.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>1.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>5.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>4.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.']
    ],
    'Full Face Wax' => [
        ['product'=>'Wax Beads','category'=>'Waxing','brand'=>'WaxPro','unit'=>'grams','buying'=>60,'selling'=>120,'min'=>1000,'qty'=>20.000,'why'=>'Wax used to remove hair.'],
        ['product'=>'Wax Applicator Sticks','category'=>'Waxing','brand'=>'WaxPro','unit'=>'piece','buying'=>70,'selling'=>150,'min'=>100,'qty'=>5.000,'why'=>'Applicator sticks used during waxing.'],
        ['product'=>'Post-Wax Soothing Gel','category'=>'Waxing','brand'=>'WaxPro','unit'=>'ml','buying'=>150,'selling'=>300,'min'=>300,'qty'=>10.000,'why'=>'Soothing gel after waxing.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>8.000,'why'=>'Cleaning/wiping after waxing.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene and protection.']
    ],
    'Armpit Facial' => [
        ['product'=>'Body Cleanser','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>10.000,'why'=>'Cleanses underarm area.'],
        ['product'=>'Exfoliating Scrub','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>200,'min'=>500,'qty'=>10.000,'why'=>'Exfoliates uneven texture.'],
        ['product'=>'Brightening Serum','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>350,'selling'=>750,'min'=>150,'qty'=>5.000,'why'=>'Targets dark underarms.'],
        ['product'=>'Body Mask','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>220,'min'=>500,'qty'=>10.000,'why'=>'Body mask.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>6.000,'why'=>'Wiping and cleaning.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene.']
    ],
    'Bikini Facial' => [
        ['product'=>'Body Cleanser','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>10.000,'why'=>'Cleanses bikini area.'],
        ['product'=>'Body Scrub Cream','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>250,'min'=>500,'qty'=>10.000,'why'=>'Exfoliation.'],
        ['product'=>'Ingrown Hair Serum','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>300,'selling'=>650,'min'=>150,'qty'=>5.000,'why'=>'Helps ingrown hairs and bumps.'],
        ['product'=>'Body Mask','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>220,'min'=>500,'qty'=>10.000,'why'=>'Soothing body mask.'],
        ['product'=>'Cotton Pads','category'=>'Consumables','brand'=>'Eden Skin','unit'=>'piece','buying'=>50,'selling'=>100,'min'=>100,'qty'=>6.000,'why'=>'Wiping and cleaning.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene.']
    ],
    'Chest Facial' => [
        ['product'=>'Body Cleanser','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>15.000,'why'=>'Cleanses chest area.'],
        ['product'=>'Body Scrub Cream','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>250,'min'=>500,'qty'=>15.000,'why'=>'Exfoliation.'],
        ['product'=>'Acne Treatment Gel','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>550,'min'=>150,'qty'=>5.000,'why'=>'Helps chest acne.'],
        ['product'=>'Body Mask','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>220,'min'=>500,'qty'=>20.000,'why'=>'Body mask.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene.']
    ],
    'Back Facial' => [
        ['product'=>'Body Cleanser','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'ml','buying'=>100,'selling'=>220,'min'=>500,'qty'=>20.000,'why'=>'Cleanses back area.'],
        ['product'=>'Body Scrub Cream','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>120,'selling'=>250,'min'=>500,'qty'=>25.000,'why'=>'Deep exfoliation.'],
        ['product'=>'Acne Treatment Gel','category'=>'Skin Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>550,'min'=>150,'qty'=>10.000,'why'=>'Targets back acne and clogged pores.'],
        ['product'=>'Body Mask','category'=>'Body Care','brand'=>'Eden Skin','unit'=>'grams','buying'=>100,'selling'=>220,'min'=>500,'qty'=>25.000,'why'=>'Back mask.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.'],
        ['product'=>'Disposable Gloves','category'=>'Consumables','brand'=>'SafeHands','unit'=>'piece','buying'=>150,'selling'=>300,'min'=>100,'qty'=>2.000,'why'=>'Hygiene.']
    ],
    'Body Shaping & Tightening - Stomach Only' => [
        ['product'=>'Slimming Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>20.000,'why'=>'Slimming gel for stomach area.'],
        ['product'=>'Firming Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>15.000,'why'=>'Firming cream for tightening.'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.500,'why'=>'Body wrap film for shaping.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Body Shaping & Tightening - Weekly Program (3 Sessions)' => [
        ['product'=>'Slimming Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>60.000,'why'=>'Slimming gel for stomach area. (3 sessions included.)'],
        ['product'=>'Firming Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>45.000,'why'=>'Firming cream for tightening. (3 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>4.500,'why'=>'Body wrap film for shaping. (3 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>3.000,'why'=>'One client towel. (3 sessions included.)']
    ],
    'Body Shaping & Tightening - Monthly Program (12 Sessions)' => [
        ['product'=>'Slimming Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>240.000,'why'=>'Slimming gel for stomach area. (12 sessions included.)'],
        ['product'=>'Firming Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>180.000,'why'=>'Firming cream for tightening. (12 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>18.000,'why'=>'Body wrap film for shaping. (12 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>12.000,'why'=>'One client towel. (12 sessions included.)']
    ],
    'Full Body Shaping - Single Session' => [
        ['product'=>'Slimming Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>50.000,'why'=>'Slimming gel for stomach, thighs and arms.'],
        ['product'=>'Firming Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>40.000,'why'=>'Firming cream for full body shaping.'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>3.000,'why'=>'Body wrap film for full body shaping.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Full Body Shaping - Weekly Program (3 Sessions)' => [
        ['product'=>'Slimming Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>150.000,'why'=>'Slimming gel for stomach, thighs and arms. (3 sessions included.)'],
        ['product'=>'Firming Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>120.000,'why'=>'Firming cream for full body shaping. (3 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>9.000,'why'=>'Body wrap film for full body shaping. (3 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>3.000,'why'=>'One client towel. (3 sessions included.)']
    ],
    'Full Body Shaping - Monthly Program (12 Sessions)' => [
        ['product'=>'Slimming Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>600.000,'why'=>'Slimming gel for stomach, thighs and arms. (12 sessions included.)'],
        ['product'=>'Firming Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>480.000,'why'=>'Firming cream for full body shaping. (12 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>36.000,'why'=>'Body wrap film for full body shaping. (12 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>12.000,'why'=>'One client towel. (12 sessions included.)']
    ],
    'Slim & Detox Heat Therapy - Stomach Only' => [
        ['product'=>'Detox Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>20.000,'why'=>'Detox gel for stomach area.'],
        ['product'=>'Heat Therapy Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>600,'min'=>500,'qty'=>15.000,'why'=>'Heat therapy cream.'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.500,'why'=>'Body wrap film for heat therapy.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Slim & Detox Heat Therapy - Weekly Program (3 Sessions)' => [
        ['product'=>'Detox Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>60.000,'why'=>'Detox gel for stomach area. (3 sessions included.)'],
        ['product'=>'Heat Therapy Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>600,'min'=>500,'qty'=>45.000,'why'=>'Heat therapy cream. (3 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>4.500,'why'=>'Body wrap film for heat therapy. (3 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>3.000,'why'=>'One client towel. (3 sessions included.)']
    ],
    'Slim & Detox Heat Therapy - Monthly Program (12 Sessions)' => [
        ['product'=>'Detox Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>240.000,'why'=>'Detox gel for stomach area. (12 sessions included.)'],
        ['product'=>'Heat Therapy Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>600,'min'=>500,'qty'=>180.000,'why'=>'Heat therapy cream. (12 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>18.000,'why'=>'Body wrap film for heat therapy. (12 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>12.000,'why'=>'One client towel. (12 sessions included.)']
    ],
    'Full Body Slim & Detox Therapy - Single Session' => [
        ['product'=>'Detox Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>60.000,'why'=>'Detox gel for stomach, thighs and arms.'],
        ['product'=>'Heat Therapy Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>600,'min'=>500,'qty'=>45.000,'why'=>'Heat therapy cream for full body.'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>3.000,'why'=>'Body wrap film for full body heat therapy.'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>1.000,'why'=>'One client towel.']
    ],
    'Full Body Slim & Detox Therapy - Weekly Program (3 Sessions)' => [
        ['product'=>'Detox Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>180.000,'why'=>'Detox gel for stomach, thighs and arms. (3 sessions included.)'],
        ['product'=>'Heat Therapy Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>600,'min'=>500,'qty'=>135.000,'why'=>'Heat therapy cream for full body. (3 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>9.000,'why'=>'Body wrap film for full body heat therapy. (3 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>3.000,'why'=>'One client towel. (3 sessions included.)']
    ],
    'Full Body Slim & Detox Therapy - Monthly Program (12 Sessions)' => [
        ['product'=>'Detox Gel','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>250,'selling'=>500,'min'=>500,'qty'=>720.000,'why'=>'Detox gel for stomach, thighs and arms. (12 sessions included.)'],
        ['product'=>'Heat Therapy Cream','category'=>'Slimming Therapy','brand'=>'Eden Skin','unit'=>'grams','buying'=>300,'selling'=>600,'min'=>500,'qty'=>540.000,'why'=>'Heat therapy cream for full body. (12 sessions included.)'],
        ['product'=>'Disposable Body Wrap Film','category'=>'Slimming Therapy','brand'=>'SlimPro','unit'=>'meter','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>36.000,'why'=>'Body wrap film for full body heat therapy. (12 sessions included.)'],
        ['product'=>'Disposable Towel','category'=>'Consumables','brand'=>'CleanPro','unit'=>'piece','buying'=>500,'selling'=>1000,'min'=>50,'qty'=>12.000,'why'=>'One client towel. (12 sessions included.)']
    ]
    ];
}

function spa_table_exists_local(string $table): bool {
    try {
        return (bool) scalar('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?', [$table]);
    } catch (Throwable $e) { return false; }
}

function spa_column_exists_local(string $table, string $column): bool {
    try {
        return (bool) scalar('SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?', [$table, $column]);
    } catch (Throwable $e) { return false; }
}

function spa_category_id(int $branchId, string $name): int {
    $id = (int) (scalar('SELECT id FROM product_categories WHERE branch_id = ? AND name = ? LIMIT 1', [$branchId, $name]) ?: 0);
    if ($id) return $id;
    // No created_at here so older installations without that column do not crash.
    q('INSERT INTO product_categories(branch_id, name, status) VALUES(?, ?, "active")', [$branchId, $name]);
    return (int) db()->lastInsertId();
}

function spa_service_category_id(int $branchId, string $name): int {
    $id = (int) (scalar('SELECT id FROM service_categories WHERE branch_id = ? AND name = ? LIMIT 1', [$branchId, $name]) ?: 0);
    if ($id) return $id;
    q('INSERT INTO service_categories(branch_id, name, status) VALUES(?, ?, "active")', [$branchId, $name]);
    return (int) db()->lastInsertId();
}

function spa_product_id(int $branchId, array $def): int {
    $id = (int) (scalar('SELECT id FROM products WHERE branch_id = ? AND name = ? LIMIT 1', [$branchId, $def['product']]) ?: 0);
    if ($id) return $id;
    $catId = spa_category_id($branchId, $def['category']);
    $barcode = 'EDEN-' . substr(hash('crc32b', $branchId . '|' . $def['product']), 0, 8);
    // No created_at here so older installations without that column do not crash.
    q('INSERT INTO products(branch_id, category_id, barcode, name, brand, unit, buying_price, selling_price, minimum_stock, status) VALUES(?,?,?,?,?,?,?,?,?,"active")', [
        $branchId, $catId, $barcode, $def['product'], $def['brand'], $def['unit'], $def['buying'], $def['selling'], $def['min']
    ]);
    $id = (int) db()->lastInsertId();
    q('INSERT IGNORE INTO stock_levels(branch_id, product_id, quantity) VALUES(?,?,0)', [$branchId, $id]);
    return $id;
}

function apply_eden_skin_menu_services(int $branchId, bool $deactivateOldTemplates = true): array {
    $addedServices = 0; $updatedServices = 0; $addedCategories = 0; $deactivatedServices = 0;
    $menuNames = [];
    foreach (spa_menu_service_catalog() as $svc) {
        $menuNames[] = $svc['name'];
        $beforeCat = (int) (scalar('SELECT COUNT(*) FROM service_categories WHERE branch_id = ? AND name = ?', [$branchId, $svc['category']]) ?: 0);
        $catId = spa_service_category_id($branchId, $svc['category']);
        if (!$beforeCat) $addedCategories++;
        $existingId = (int) (scalar('SELECT id FROM services WHERE branch_id = ? AND name = ? LIMIT 1', [$branchId, $svc['name']]) ?: 0);
        if ($existingId) {
            q('UPDATE services SET category_id=?, description=?, duration_minutes=?, price=?, commission_type=?, commission_value=?, status="active", continuation_required=?, continuation_after_days=?, continuation_message=?, updated_at=NOW() WHERE id=? AND branch_id=?', [
                $catId, $svc['description'], $svc['duration'], $svc['price'], $svc['commission_type'], $svc['commission_value'], $svc['continuation_days'] > 0 ? 1 : 0, $svc['continuation_days'], $svc['continuation_message'] ?: null, $existingId, $branchId
            ]);
            $updatedServices++;
        } else {
            q('INSERT INTO services(branch_id, category_id, name, description, duration_minutes, price, commission_type, commission_value, status, continuation_required, continuation_after_days, continuation_message) VALUES(?,?,?,?,?,?,?, ?,"active",?,?,?)', [
                $branchId, $catId, $svc['name'], $svc['description'], $svc['duration'], $svc['price'], $svc['commission_type'], $svc['commission_value'], $svc['continuation_days'] > 0 ? 1 : 0, $svc['continuation_days'], $svc['continuation_message'] ?: null
            ]);
            $addedServices++;
        }
    }
    if ($deactivateOldTemplates && $menuNames) {
        $oldTemplates = ['Hair Cut','Hair Wash','Hair Relaxing','Hair Coloring','Hair Treatment','Braiding','Weaving','Wig Installation','Nail Polish','Gel Nails','Pedicure','Manicure','Facial','Full Body Massage','Steam Bath','Body Scrub','Waxing','Eyebrow Threading','Makeup','Bridal Makeup','Henna','Eyelashes'];
        $ph = implode(',', array_fill(0, count($oldTemplates), '?'));
        $params = array_merge([$branchId], $oldTemplates);
        q('UPDATE services SET status="inactive", updated_at=NOW() WHERE branch_id=? AND name IN ('.$ph.')', $params);
        $deactivatedServices = (int) db()->query('SELECT ROW_COUNT()')->fetchColumn();
    }
    return compact('addedCategories','addedServices','updatedServices','deactivatedServices');
}

function apply_spa_recommended_consumption(int $branchId, bool $replaceExisting = false): array {
    $menu = apply_eden_skin_menu_services($branchId, true);
    $catalog = spa_consumption_catalog();
    $addedProducts = 0; $addedRules = 0; $updatedRules = 0; $skippedServices = 0;
    foreach ($catalog as $serviceName => $defs) {
        $serviceId = (int) (scalar('SELECT id FROM services WHERE branch_id = ? AND name = ? LIMIT 1', [$branchId, $serviceName]) ?: 0);
        if (!$serviceId) { $skippedServices++; continue; }
        foreach ($defs as $def) {
            $before = (int) (scalar('SELECT COUNT(*) FROM products WHERE branch_id = ? AND name = ?', [$branchId, $def['product']]) ?: 0);
            $productId = spa_product_id($branchId, $def);
            if (!$before) $addedProducts++;
            $exists = (int) (scalar('SELECT COUNT(*) FROM service_products WHERE service_id = ? AND product_id = ?', [$serviceId, $productId]) ?: 0);
            if ($exists) {
                if ($replaceExisting) {
                    q('UPDATE service_products SET quantity_used = ? WHERE service_id = ? AND product_id = ?', [$def['qty'], $serviceId, $productId]);
                    $updatedRules++;
                }
            } else {
                q('INSERT INTO service_products(service_id, product_id, quantity_used) VALUES(?,?,?)', [$serviceId, $productId, $def['qty']]);
                $addedRules++;
            }
        }
    }
    return ['menu'=>$menu,'addedProducts'=>$addedProducts,'addedRules'=>$addedRules,'updatedRules'=>$updatedRules,'skippedServices'=>$skippedServices];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['_action'] ?? 'save';

    if ($action === 'apply_defaults') {
        db()->beginTransaction();
        try {
            $result = apply_spa_recommended_consumption($bid, !empty($_POST['replace_existing']));
            audit('update', 'service_products', 0, ['eden_skin_defaults' => $result]);
            db()->commit();
            flash('success', 'Eden Skin services and consumption setup applied. Services added: ' . $result['menu']['addedServices'] . ', services updated: ' . $result['menu']['updatedServices'] . ', old template services deactivated: ' . $result['menu']['deactivatedServices'] . ', products added: ' . $result['addedProducts'] . ', rules added: ' . $result['addedRules'] . ', rules updated: ' . $result['updatedRules'] . '.');
        } catch (Throwable $e) {
            db()->rollBack(); flash('error', $e->getMessage());
        }
        redirect('modules/service_consumption.php?tab=overview');
    }

    if ($action === 'save') {
        $serviceId = (int) ($_POST['service_id'] ?? 0);
        if (!$serviceId || !scalar('SELECT id FROM services WHERE id = ? AND branch_id = ?', [$serviceId, $bid])) {
            flash('error', 'Select a valid service.'); redirect('modules/service_consumption.php');
        }
        q('DELETE FROM service_products WHERE service_id = ?', [$serviceId]);
        foreach (($_POST['product_id'] ?? []) as $i => $pid) {
            $pid = (int) $pid; $qty = (float) ($_POST['quantity_used'][$i] ?? 0);
            if ($pid && $qty > 0) q('INSERT INTO service_products(service_id, product_id, quantity_used) VALUES(?,?,?)', [$serviceId, $pid, $qty]);
        }
        audit('update', 'service_products', $serviceId);
        flash('success', 'Service product consumption saved.');
        redirect('modules/service_consumption.php?tab=manage&service_id=' . $serviceId);
    }
}

$tab = $_GET['tab'] ?? 'overview';
$services = service_options();
$serviceId = (int) ($_GET['service_id'] ?? 0);
if (!$serviceId && $services) $serviceId = (int) array_key_first($services);

$rows = $serviceId ? all('SELECT sp.*, p.name product, p.unit, p.brand, COALESCE(sl.quantity,0) stock_qty FROM service_products sp JOIN products p ON p.id = sp.product_id LEFT JOIN stock_levels sl ON sl.product_id = p.id AND sl.branch_id = p.branch_id WHERE sp.service_id = ? ORDER BY p.name', [$serviceId]) : [];
$productOptions = product_options();

$recipes = all('SELECT s.id service_id, s.name service_name, s.price service_price, p.name product_name, p.brand, p.unit, sp.quantity_used, COALESCE(sl.quantity,0) stock_qty FROM services s LEFT JOIN service_products sp ON sp.service_id = s.id LEFT JOIN products p ON p.id = sp.product_id LEFT JOIN stock_levels sl ON sl.product_id = p.id AND sl.branch_id = s.branch_id WHERE s.branch_id = ? AND s.status = "active" ORDER BY s.name, p.name', [$bid]);
$recipeMap = [];
foreach ($recipes as $r) {
    $recipeMap[$r['service_id']]['service_name'] = $r['service_name'];
    $recipeMap[$r['service_id']]['service_price'] = $r['service_price'];
    if (!empty($r['product_name'])) $recipeMap[$r['service_id']]['products'][] = $r;
}
$recommended = spa_consumption_catalog();
$title = 'Automatic Product Consumption';
$subtitle = 'Eden Skin menu services with clear recipe-style stock deductions.';
include dirname(__DIR__) . '/includes/header.php';
?>

<div class="toolbar">
    <a class="btn <?= $tab === 'overview' ? '' : 'light' ?>" href="?tab=overview">All Service Recipes</a>
    <a class="btn <?= $tab === 'manage' ? '' : 'light' ?>" href="?tab=manage&service_id=<?= e($serviceId) ?>">Manage One Service</a>
    <a class="btn light" href="services.php">Back to Services</a>
</div>

<?php if ($tab === 'manage'): ?>
<section class="card">
    <h2>Manage Product Consumption for One Service</h2>
    <p class="muted">This page controls what stock is deducted automatically when a service is sold in POS. Example: 10 ml Facial Cleanser means every sale of that service deducts 10 ml.</p>
    <form method="get" class="toolbar">
        <input type="hidden" name="tab" value="manage"><label>Service</label>
        <select name="service_id" data-autosubmit>
            <?php foreach ($services as $id => $label): ?><option value="<?= e($id) ?>" <?= selected($serviceId, $id) ?>><?= e($label) ?></option><?php endforeach; ?>
        </select>
    </form>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="_action" value="save"><input type="hidden" name="service_id" value="<?= e($serviceId) ?>">
        <div class="table-wrap"><table><thead><tr><th>Product Used by this Service</th><th>Quantity deducted for 1 service</th><th>Current Unit / Stock</th><th></th></tr></thead><tbody id="lines">
            <?php $init = $rows ?: [['product_id'=>'','quantity_used'=>'','unit'=>'','stock_qty'=>'']]; ?>
            <?php foreach ($init as $r): ?><tr><td><select name="product_id[]"><option value="">Select product</option><?php foreach ($productOptions as $pid => $label): ?><option value="<?= e($pid) ?>" <?= selected($r['product_id'] ?? '', $pid) ?>><?= e($label) ?></option><?php endforeach; ?></select></td><td><input type="number" step="0.001" min="0" name="quantity_used[]" value="<?= e($r['quantity_used'] ?? '') ?>" placeholder="Example 10 ml or 1 piece"></td><td><?= e(($r['unit'] ?? '') ? (($r['stock_qty'] ?? 0) . ' ' . $r['unit']) : 'Choose product') ?></td><td><button type="button" class="btn small danger" onclick="this.closest('tr').remove()">Remove</button></td></tr><?php endforeach; ?>
        </tbody></table></div>
        <button type="button" class="btn secondary" onclick="addLine()">+ Add Product</button> <button class="btn">Save Consumption Logic</button>
    </form>
</section>
<section class="card"><h2>How to read the numbers</h2><div class="grid cols-3"><div><strong>1 piece</strong><br><span class="muted">One full item is deducted, like one towel, blade, mask, or cartridge.</span></div><div><strong>10 ml / 15 grams</strong><br><span class="muted">A measured amount of liquid or cream is deducted. This is clearer than 0.100 bottle.</span></div><div><strong>3-session program</strong><br><span class="muted">Program services deduct the total expected products for all sessions included.</span></div></div></section>
<script>
function addLine(){
    const html = `<tr><td><select name="product_id[]"><option value="">Select product</option><?php foreach ($productOptions as $pid => $label): ?><option value="<?= e($pid) ?>"><?= e($label) ?></option><?php endforeach; ?></select></td><td><input type="number" step="0.001" min="0" name="quantity_used[]" placeholder="Example 10 or 1"></td><td>Choose product</td><td><button type="button" class="btn small danger" onclick="this.closest('tr').remove()">Remove</button></td></tr>`;
    document.querySelector('#lines').insertAdjacentHTML('beforeend', html);
}
</script>
<?php else: ?>
<section class="card">
    <h2>Eden Skin Menu Services & Product Recipes</h2>
    <p class="muted">Use this to make the system match the Eden Skin menu you uploaded. It adds/updates the actual services, deactivates old demo salon services, and configures automatic product deductions.</p>
    <div class="toolbar">
        <form method="post" style="display:inline-block"><?= csrf_field() ?><input type="hidden" name="_action" value="apply_defaults"><button class="btn secondary" data-confirm="This will add/update Eden Skin menu services and add missing product consumption rules. Existing custom quantities will be kept.">Add / Update Eden Skin Services</button></form>
        <form method="post" style="display:inline-block"><?= csrf_field() ?><input type="hidden" name="_action" value="apply_defaults"><input type="hidden" name="replace_existing" value="1"><button class="btn light" data-confirm="This will reset Eden Skin service recipes to the recommended quantities. Continue only if you want to replace current consumption quantities.">Reset to Eden Skin Recommendations</button></form>
    </div>
    <div class="table-wrap"><table><thead><tr><th>Service</th><th>Products deducted automatically</th><th>Action</th></tr></thead><tbody>
        <?php foreach ($recipeMap as $sid => $data): ?><tr><td><strong><?= e($data['service_name']) ?></strong><br><small><?= money($data['service_price']) ?></small></td><td><?php if (!empty($data['products'])): ?><?php foreach ($data['products'] as $p): ?><div style="margin-bottom:6px"><strong><?= e(number_format((float)$p['quantity_used'], 3)) ?> <?= e($p['unit']) ?></strong> of <?= e($p['product_name']) ?> <?= $p['brand'] ? '<small>(' . e($p['brand']) . ')</small>' : '' ?> <small>Stock: <?= e(number_format((float)$p['stock_qty'], 3)) ?> <?= e($p['unit']) ?></small></div><?php endforeach; ?><?php else: ?><span class="badge orange">No automatic product deduction configured</span><?php endif; ?></td><td><a class="btn small secondary" href="?tab=manage&service_id=<?= e($sid) ?>">Change Logic</a></td></tr><?php endforeach; ?>
    </tbody></table></div>
</section>
<section class="card"><h2>Recommended Eden Skin Scenarios</h2><p class="muted">These are the recommended products that will be deducted when the service is sold in POS. You can change any quantity from Manage One Service.</p><div class="table-wrap"><table><thead><tr><th>Service Scenario</th><th>Products normally used</th></tr></thead><tbody><?php foreach ($recommended as $serviceName => $defs): ?><tr><td><strong><?= e($serviceName) ?></strong></td><td><?php foreach ($defs as $def): ?><div style="margin-bottom:6px"><strong><?= e(number_format((float)$def['qty'], 3)) ?> <?= e($def['unit']) ?></strong> of <?= e($def['product']) ?> — <small><?= e($def['why']) ?></small></div><?php endforeach; ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<?php endif; ?>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>

<?php
// called database connection
include("connect.php");
// user management
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];

// Declaring post values
$longName = $_POST['longName'];
$shortName = $_POST['shortName'];
$description = $_POST['description'];
$autoRenew = $_POST['autoRenew'];
$currency = $_POST['currency'];
$depositDefault = $_POST['depositDefault'];
$depositMin = $_POST['depositMin'];
$depositMax = $_POST['depositMax'];
$interestRateDefault = $_POST['interestRateDefault'];
$interestRateMin = $_POST['interestRateMin'];
$interestRateMax = $_POST['interestRateMax'];
$compoundPeriod = $_POST['compoundPeriod'];
$interestPostType = $_POST['interestPostType'];
$intCalType = $_POST['intCalType'];
$intCalDays = $_POST['intCalDays'];
$minimumDepTerm = $_POST['minimumDepTerm'];
$minimumDepTermTime = $_POST['minimumDepTermTime'];
$maximumDepTerm = $_POST['maximumDepTerm'];
$maximumDepTermTime = $_POST['maximumDepTermTime'];
$inMultiplesDepTerm = $_POST['inMultiplesDepTerm'];
$inMultiplesDepTermTime = $_POST['inMultiplesDepTermTime'];
$lockPerFreq = $_POST['lockPerFreq'];
$lockPerFreqTime = $_POST['lockPerFreqTime'];
$prematureClosingPenalty = $_POST['prematureClosingPenalty'];
$glCode = $_POST['glCode'];

// Query to Input data into table
if (isset($glCode)) {
    $createProductCon = [
        'int_id' => $sessint_id,
        'branch_id' => $branch_id,
        'name' => $longName,
        'short_name' => $shortName,
        'description' => $description,
        'currency_code' => $currency,
        'currency_digits' => 2,
        'interest_compounding_period_enum' => $compoundPeriod,
        'interest_posting_period_enum' => $interestPostType,
        'interest_calculation_type_enum' => $intCalType,
        'interest_calculation_days_in_year_type_enum' => $intCalDays,
        'lockin_period_frequency' => $lockPerFreq,
        'lockin_period_frequency_enum' => $lockPerFreqTime,
        'accounting_type' => 3,
        'deposit_amount' => $depositDefault,
        'min_deposit_amount' => $depositMin,
        'max_deposit_amount' => $depositMax,
        'minimum_deposit_term' => $minimumDepTerm,
        'minimum_deposit_term_time' => $minimumDepTermTime,
        'maximum_deposit_term' => $maximumDepTerm,
        'maximum_deposit_term_time' => $maximumDepTermTime,
        'in_multiples_deposit_term' => $inMultiplesDepTerm,
        'in_multiples_deposit_term_time' => $inMultiplesDepTermTime,
        'allow_overdraft' => $prematureClosingPenalty,
        'auto_renew_on_closure' => $autoRenew
    ];
    $createProduct = create('savings_product', $createProductCon);
    if ($createProduct) {
        // query to add charges
        $name = $longName . ' ' . $shortName;
        $createChargesCon = [
            'int_id' => $sessint_id,
            'cache_prod_id' => $name
        ];

        $charges = selectAll('charges_cache', $createChargesCon);

        foreach ($charges as $charge) {
            $id = $charge['id'];
            $ftdIdCon = [
                'int_id' => $sessint_id,
                'branch_id' => $branch_id,
                'name' => $longName,
                'short_name' => $shortName
            ];
            $ftdIdDetails = selectSpecificData('savings_product', ['id'], $ftdIdCon);
            $ftdId = $ftdIdDetails['id'];
            $chargeId = $charge['charge_id'];
            $ftdChargeCon = ['int_id' => $sessint_id, 'ftd_id' => $ftdId, 'charge_id' => $chargeId];
            $ftdCharge = create('ftd_product_charge', $ftdChargeCon);
            if ($ftdCharge) {
                $deleteCharge = delete('charges_cache', $id, 'id');
            }
        }
        $_SESSION["Lack_of_intfund_$randms"] = "Product Created Successfully";
        $number = 100;
        header("Location: ../mfi/products_config.php?messageFTD3=$number");
        exit();
    }
}
?>

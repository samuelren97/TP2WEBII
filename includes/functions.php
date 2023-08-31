<?php declare(strict_types=1);

function redirectToIndexAndExit() : void{
    header('Location: index.php');
    exit();
}

function redirectToErrorPageAndExit() : void {
    header('Location: error404.php');
    exit();
}

function isValidEmail(string $email) : bool {
    $regex = "/[a-z0-9]+@[a-z]+.[a-z]{2,3}/";
    if (preg_match($regex, $email) == 1) {
        return true;
    }
    return false;
}

function getProductIndexInArray(int $skuToFind, array $array) : int {
    $INDEX_NOT_FOUND_CODE = -1;
    for($i=0; $i < count($array); $i++) {
        $productSku= $array[$i]->getProduct()->getSku();
        if ($productSku == $skuToFind) {
            return $i;
        }
    }
    return $INDEX_NOT_FOUND_CODE;
}
?>
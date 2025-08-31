<?php
session_start();

require_once __DIR__ . '/../Modules/ProductModel.php';

class PoductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function handleRequest()
    {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case 'toggle_favourite':
                    $this->toggleFavourite();
                    break;
                case 'AddToBasket':
                    $this->addToBasket();
                    break;
                case 'deleteProduct':
                    // Assuming this action is handled by an admin and requires a different model/logic
                    // For now, it remains as is or will be moved to a more appropriate controller/model
                    break;
                case 'deleteBasketProduct':
                    $this->deleteBasketProduct();
                    break;
                default:
                    // Handle unknown action or log it
                    break;
            }
        }
    }

    private function toggleFavourite()
    {
        if (!isset($_SESSION['id'])) {
            // Redirect to login or handle error
            return;
        }

        $productId = (int)($_GET['product_id'] ?? 0);
        $userId = (int)$_SESSION['id'];

        if ($productId > 0) {
            try {
                $this->productModel->toggleFavourite($userId, $productId);
            } catch (PDOException $e) {
                error_log("Ошибка: " . $e->getMessage());
            }
        }
        $this->redirectBack();
    }

    private function addToBasket()
    {
        if (!isset($_SESSION['id'])) {
            // Redirect to login or handle error
            return;
        }

        $productId = (int)($_GET['product_id'] ?? 0);
        $userId = (int)$_SESSION['id'];

        if ($productId > 0) {
            try {
                $this->productModel->addToBasket($userId, $productId);
            } catch (PDOException $e) {
                error_log("Ошибка: " . $e->getMessage());
            }
        }
        $this->redirectBack();
    }

    private function deleteBasketProduct()
    {
        if (!isset($_SESSION['id'])) {
            // Redirect to login or handle error
            return;
        }

        $basketId = (int)($_GET['id'] ?? 0);

        if ($basketId > 0) {
            try {
                $this->productModel->deleteBasketItem($basketId);
            } catch (PDOException $e) {
                error_log("Ошибка deleteBasketProduct в ProductController: " . $e->getMessage());
            }
        }
        $this->redirectBack();
    }

    private function redirectBack()
    {
        if (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) {
            header("Location: " . $_GET['redirect_url']);
            exit;
        } else {
            $redirect_query = http_build_query(['query' => $_GET['query'] ?? '']);
            header("Location: ../pages/search.php?" . $redirect_query);
            exit;
        }
    }

    public function getFavourites(int $userId): array
    {
        try {
            return $this->productModel->getFavouritesByUserId($userId);
        } catch (PDOException $e) {
            error_log("Ошибка getFavourites в ProductController: " . $e->getMessage());
            return [];
        }
    }

    public function getBasketItems(int $userId): array
    {
        try {
            return $this->productModel->getBasketItemsWithDetails($userId);
        } catch (PDOException $e) {
            error_log("Ошибка getBasketItems в ProductController: " . $e->getMessage());
            return [];
        }
    }

    public function getBasketItemIds(int $userId): array
    {
        try {
            return $this->productModel->getBasketItemsByUserId($userId);
        } catch (PDOException $e) {
            error_log("Ошибка getBasketItemIds в ProductController: " . $e->getMessage());
            return [];
        }
    }

    public function getFavouriteProductsWithDetails(int $userId): array
    {
        try {
            return $this->productModel->getFavouriteProductsWithDetails($userId);
        } catch (PDOException $e) {
            error_log("Ошибка getFavouriteProductsWithDetails в ProductController: " . $e->getMessage());
            return [];
        }
    }
}

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    $controller = new PoductController();
    $controller->handleRequest();
}
?>
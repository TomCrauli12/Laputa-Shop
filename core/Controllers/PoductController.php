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
        if (isset($_GET['action']) || (isset($_POST['action']) && $_SERVER['REQUEST_METHOD'] === 'POST')) {
            $action = $_GET['action'] ?? $_POST['action'];
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
        header('Content-Type: application/json');
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован.']);
            return;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $userId = (int)$_SESSION['id'];
        $isFavourite = false;

        if ($productId > 0) {
            try {
                $this->productModel->toggleFavourite($userId, $productId);
                // Check if it's now a favourite
                $favourites = $this->productModel->getFavouritesByUserId($userId);
                $isFavourite = in_array($productId, $favourites);
                echo json_encode(['success' => true, 'message' => 'Статус избранного обновлен.', 'isFavourite' => $isFavourite]);
            } catch (PDOException $e) {
                error_log("Ошибка: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Ошибка при обновлении статуса избранного.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неверный ID продукта.']);
        }
    }

    private function addToBasket()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован.']);
            return;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $userId = (int)$_SESSION['id'];

        if ($productId > 0) {
            try {
                $this->productModel->addToBasket($userId, $productId);
                echo json_encode(['success' => true, 'message' => 'Товар добавлен в корзину.']);
            } catch (PDOException $e) {
                error_log("Ошибка: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении товара в корзину.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неверный ID продукта.']);
        }
    }

    private function deleteBasketProduct()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован.']);
            return;
        }

        $basketId = (int)($_POST['id'] ?? 0);

        if ($basketId > 0) {
            try {
                $this->productModel->deleteBasketItem($basketId);
                echo json_encode(['success' => true, 'message' => 'Товар удален из корзины.']);
            } catch (PDOException $e) {
                error_log("Ошибка deleteBasketProduct в ProductController: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Ошибка при удалении товара из корзины.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неверный ID корзины.']);
        }
    }

    private function redirectBack()
    {
        if (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) {
            header("Location: " . $_GET['redirect_url']);
            exit;
        } elseif (isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])) {
            header("Location: " . $_POST['redirect_url']);
            exit;
        }else {
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
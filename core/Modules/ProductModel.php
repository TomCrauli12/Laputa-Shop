<?php

require_once __DIR__ . '/../../DB/start.php';

class ProductModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function toggleFavourite(int $userId, int $productId): bool
    {
        $stmt = $this->conn->prepare("SELECT id FROM favourites WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $favourite = $stmt->fetch();

        if ($favourite) {
            $this->conn->prepare("DELETE FROM favourites WHERE id = ?")->execute([$favourite['id']]);
            return false;
        } else {
            $this->conn->prepare("INSERT INTO favourites (user_id, product_id) VALUES (?, ?)")
                ->execute([$userId, $productId]);
            return true;
        }
    }

    public function addToBasket(int $userId, int $productId): bool
    {
        $stmt = $this->conn->prepare("SELECT id FROM basket WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $basketItem = $stmt->fetch();

        if (!$basketItem) {
            $this->conn->prepare("INSERT INTO basket (user_id, product_id, quantity) VALUES (?, ?, 1)")
                ->execute([$userId, $productId]);
            return true;
        }
        return false;
    }

    public function getFavouritesByUserId(int $userId): array
    {
        $stmt = $this->conn->prepare("SELECT product_id FROM favourites WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getBasketItemsByUserId(int $userId): array
    {
        $stmt = $this->conn->prepare("SELECT product_id FROM basket WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function deleteBasketItem(int $basketId): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM basket WHERE id = ?");
        return $stmt->execute([$basketId]);
    }

    public function getFavouriteProductsWithDetails(int $userId): array
    {
        $stmt = $this->conn->prepare('SELECT f.id as favourite_id, p.* FROM favourites f JOIN products p ON f.product_id = p.id WHERE f.user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBasketItemsWithDetails(int $userId): array
    {
        $stmt = $this->conn->prepare('SELECT b.id as basket_id, b.product_id, b.quantity, p.* FROM basket b JOIN products p ON b.product_id = p.id WHERE b.user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
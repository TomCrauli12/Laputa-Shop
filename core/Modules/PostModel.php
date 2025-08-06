<?
require_once __DIR__ . '/../../DB/start.php';

class PostModel{

    static function deletePost($id){

        $conn = DB::getConnection();

        $query = $conn->prepare("DELETE FROM products WHERE id = ?");

        $query->execute([$id]);


    }

static function createProduct($title, $descr, $price, $category, $files, $categorytwo, $info_block, $files_2, $files_3, $files_4, $files_5) {
    $conn = DB::getConnection();

    $uploadedFileName = '';
    if (isset($_FILES['files']) && $_FILES['files']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
        $uploadedFileName = uniqid('', true) . '.' . $ext;
        $uploadPath = '../../image/image_product/' . $uploadedFileName;
        
        if (!move_uploaded_file($_FILES['files']['tmp_name'], $uploadPath)) {
            throw new Exception('Ошибка загрузки главного изображения');
        }
    } else {
        throw new Exception('Главное изображение обязательно для загрузки');
    }
    $uploadedFiles = ['', '', '', ''];
    
    $additionalFiles = [
        'files_2' => 0,
        'files_3' => 1,
        'files_4' => 2,
        'files_5' => 3
    ];
    
    foreach ($additionalFiles as $fileKey => $index) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
            $filename = uniqid('', true) . '.' . $ext;
            $uploadPath = '../../image/image_product/' . $filename;
            
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $uploadPath)) {
                $uploadedFiles[$index] = $filename;
            }
        }
    }
    $query = $conn->prepare("INSERT INTO `products` 
        (title, descr, price, category, files, categorytwo, info_block, files_2, files_3, files_4, files_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $query->execute([
        $title,
        $descr,
        $price,
        $category,
        $uploadedFileName,
        $categorytwo,
        $info_block,
        $uploadedFiles[0],
        $uploadedFiles[1],
        $uploadedFiles[2],
        $uploadedFiles[3]
    ]);
}

    public static function getProductsByBlockDBName($blockDBName) {
        $conn = DB::getConnection();
        
        // Предполагаем, что в таблице products есть поле block_db_name
        $stmt = $conn->prepare("SELECT * FROM products WHERE info_block = :blockDBName ORDER BY id DESC LIMIT 5");
        $stmt->bindParam(':blockDBName', $blockDBName);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // public static function getInfoBlock($blockDBName) {
    //     $conn = DB::getConnection();
        
    //     // Предполагаем, что в таблице products есть поле info_block_db_name
    //     $stmt = $conn->prepare("SELECT * FROM products WHERE infoBlockDBName = :blockDBName LIMIT 5");
    //     $stmt->bindParam(':blockDBName', $blockDBName);
    //     $stmt->execute();
        
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    static function getCategory($category_name){

        $conn = DB::getConnection();

        $query =  $conn->prepare('select * from `products` where category = ?');

        $query->execute([$category_name]);

        $result = $query->fetchAll();

        return $result;
    }

    static function getinfoConteiner($info_conteiner){

        $conn = DB::getConnection();

        $query =  $conn->prepare('select * from `products` where info_block = ?');

        $query->execute([$info_conteiner]);

        $result = $query->fetchAll();

        return $result;
    }






    static function getSort($min_value, $max_value, $category){

        $conn = DB::getConnection();

        $query =  $conn->prepare('SELECT * FROM `products` WHERE price BETWEEN ? AND ? AND category = ?');

        $query->execute([$min_value, $max_value, $category]);

        $result = $query->fetchAll();

        return $result;

    }

    static function AddToBasket($product_id, $user_id){

        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO `basket` (product_id, user_id) values (?,?)");

        $query->execute([$product_id, $user_id]);

    }

    static function AddToFavourites($product_id, $user_id){

        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO `favourites` (product_id, user_id) values (?,?)");

        $query->execute([$product_id, $user_id]);
    }

        static function AddToBascet($product_id, $user_id){

        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO `bascet` (product_id, user_id) values (?,?)");

        $query->execute([$product_id, $user_id]);
    }


    static function deleteProduct($id){

        $conn = DB::getConnection();

        $query = $conn->prepare("DELETE FROM `basket` WHERE id = ?");

        $query->execute([$id]);

    }

    static function deleteFavourites($id){

        $conn = DB::getConnection();

        $query = $conn->prepare("DELETE FROM `favourites` WHERE id = ?");

        $query->execute([$id]);

    }

}

class slider{
        
    public static function addSlider($imageslider) {
        
        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO `sliders` (`imageslider`) VALUES (?)");
        
        $uploadedFileName = '';
        if (isset($_FILES['imageslider']) && $_FILES['imageslider']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imageslider']['name'], PATHINFO_EXTENSION);
            $uploadedFileName = uniqid('', true) . '.' . $ext;
            $uploadPath = '../../image/slider/' . $uploadedFileName;
            
            if (!move_uploaded_file($_FILES['imageslider']['tmp_name'], $uploadPath)) {
                throw new Exception('Ошибка загрузки изображения слайдера');
            }
        } else {
            throw new Exception('Файл не был загружен или произошла ошибка');
        }
        $query->execute([$uploadedFileName]);

        return $uploadedFileName;
    }


    static function deleteSlider(){

    }

    static function redactSlider($id){

    }

}

class category{

    static function addCategory($categoryName, $categoryBDName){
    
        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO `category` (`categoryName`, `categoryBDName`) VALUES (?, ?)");
        
        $query->execute([$categoryName, $categoryBDName]);
    }


}
class infoBlock{

    static function addInfoBlock($infoBlockName, $infoBlockDBName){
    
        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO `infoblock` (`infoBlockName`, `infoBlockDBName`) VALUES (?, ?)");
        
        $query->execute([$infoBlockName, $infoBlockDBName]);
    }

}

<?

// модель бд контроллер бек

require_once $_SERVER['DOCUMENT_ROOT'].'../start.php';

class PostModel{

    static function deletePost($id){

        $conn = DB::getConnection();

        $query = $conn->prepare("DELETE FROM products WHERE id = ?");

        $query->execute([$id]);


    }

    static function createPost($title, $descr, $price, $category, $files, $categorytwo, $info_block, $files_2, $files_3, $files_4, $files_5){
        
        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO products (title,descr,price,category,files,categorytwo,info_block,files_2,files_3,files_4,files_5) values (?,?,?,?,?,?,?,?,?,?,?)");

        $query->execute([$title,$descr,$price,$category,$files,$categorytwo,$info_block,$files_2,$files_3,$files_4,$files_5]);

        $_FILES['files'];

        $_FILES['files']['type'];

        $_FILES['files']['tmp_name'];

        $_FILES['files_2'];

        $_FILES['files_2']['type'];

        $_FILES['files_2']['tmp_name'];

        $_FILES['files_3'];

        $_FILES['files_3']['type'];

        $_FILES['files_3']['tmp_name'];

        $_FILES['files_4'];

        $_FILES['files_4']['type'];

        $_FILES['files_4']['tmp_name'];

        $_FILES['files_5'];

        $_FILES['files_5']['type'];

        $_FILES['files_5']['tmp_name'];


        if(move_uploaded_file($_FILES['files']['tmp_name'], '../image/image_product/'.$_FILES['files']['name'])) {
            echo 'файл загружен';
        } else {
            echo 'ошибка загрузки';
        }

        if(move_uploaded_file($_FILES['files_2']['tmp_name'], '../image/image_product/'.$_FILES['files_2']['name'])) {
            echo 'файл загружен';
        } else {
            echo 'ошибка загрузки';
        }

        if(move_uploaded_file($_FILES['files_3']['tmp_name'], '../image/image_product/'.$_FILES['files_3']['name'])) {
            echo 'файл загружен';
        } else {
            echo 'ошибка загрузки';
        }

        if(move_uploaded_file($_FILES['files_4']['tmp_name'], '../image/image_product/'.$_FILES['files_4']['name'])) {
            echo 'файл загружен';
        } else {
            echo 'ошибка загрузки';
        }

        if(move_uploaded_file($_FILES['files_5']['tmp_name'], '../image/image_product/'.$_FILES['files_5']['name'])) {
            echo 'файл загружен';
        } else {
            echo 'ошибка загрузки';
        }
    
    }

    static function getInfoBlock($block_name){

        $conn = DB::getConnection();

        $query = $conn->prepare('select * from products where info_block = ?');
        //подготовка в таблице продуктс где инфо блок равен неизвестно
        $query->execute([$block_name]);
        // тут подставляем значение скидки
        $result = $query->fetchAll();

        return $result;
    
    }
    static function getCategory($category_name){

        $conn = DB::getConnection();

        $query =  $conn->prepare('select * from products where category = ?');

        $query->execute([$category_name]);

        $result = $query->fetchAll();

        return $result;
    }

    static function getinfoConteiner($info_conteiner){

        $conn = DB::getConnection();

        $query =  $conn->prepare('select * from products where info_block = ?');

        $query->execute([$info_conteiner]);

        $result = $query->fetchAll();

        return $result;
    }






    static function getSort($min_value, $max_value, $category){

        $conn = DB::getConnection();

        $query =  $conn->prepare('SELECT * FROM products WHERE price BETWEEN ? AND ? AND category = ?');

        $query->execute([$min_value, $max_value, $category]);

        $result = $query->fetchAll();

        return $result;

    }

    static function AddToBasket($product_id, $user_id){

        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO basket (product_id, user_id) values (?,?)");

        $query->execute([$product_id, $user_id]);

    }

    static function AddToFavourites($product_id, $user_id){

        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO favourites (product_id, user_id) values (?,?)");

        $query->execute([$product_id, $user_id]);
    }

        static function AddToBascet($product_id, $user_id){

        $conn = DB::getConnection();

        $query = $conn->prepare("INSERT INTO bascet (product_id, user_id) values (?,?)");

        $query->execute([$product_id, $user_id]);
    }


    static function deleteProduct($id){

        $conn = DB::getConnection();

        $query = $conn->prepare("DELETE FROM basket WHERE id = ?");

        $query->execute([$id]);

    }

    static function deleteFavourites($id){

        $conn = DB::getConnection();

        $query = $conn->prepare("DELETE FROM favourites WHERE id = ?");

        $query->execute([$id]);

    }








}
<?php
    require_once 'database.php';
    //get categoryID
    $category_id=filter_input(INPUT_GET, 'category_id',FILTER_VALIDATE_INT);
    //validate category_id
    if($category_id==null||$category_id==false){
        $category_id=1;
    }
    //get name for selected category
    $querycategory='select * from categories where categoryID=:category_id';
    
    $statement1=$db->prepare($querycategory);
    $statement1->bindvalue(':category_id',$category_id);
    $statement1->execute();
    $category=$statement1->fetch();
    $category_name=$category['categoryName'];
    $statement1->closecursor();
    
    //get all categories
    $queryallcategories='select * from categories order by categoryID';
    
    $statement2=$db->prepare($queryallcategories);
    $statement2->execute();
    $categories=$statement2->fetchall();
    $statement2->closecursor();
    
    //get products for selected category
    
    $queryproducts='select * from products where categoryID=:category_id order by productID';
    $statement3=$db->prepare($queryproducts);
    $statement3->bindvalue(':category_id',$category_id);
    $statement3->execute();
    $products=$statement3->fetchall();
    $statement3->closecursor();
    ?>
        <!doctype html>
        <html>
            <head>
                <title>my guitar shop</title>
                <!---the head section -->
                <link rel="stylesheet" type="text/css" href="main.css">
            </head>
            <!-- body section-->
            <body>
                <main>
                    <h1>Product List</h1>
                    <aside>
                        <!--Display a list of categories-->
                        <h2>Categories</h2>
                        <nav>
                            <ul>
                                <?php foreach($categories as $category):?>
                                <li>
                                    <a href="?category_id=<?php echo $category['categoryID'];?>"><?php echo $category['categoryName']; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    </aside>
                    <section>
                        <!-- display a table of products -->
                        <h2><?php echo $category_name; ?></h2>
                        <table>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th class="right">Price</th>
                            </tr>
                            <?php foreach($products as $product): ?>
                            <tr>
                                <td><?php echo $product['productCode']; ?></td>
                                <td><?php echo $product['productName']; ?></td>
                                <td class="right"><?php echo $product['listPrice']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </section>
                </main>
                <footer></footer>
            </body>
        </html>
    
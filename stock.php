<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมคิดเงิน เทพทัย</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/stock.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <?php session_start();
    if ($_SESSION) {
        include('./api/dbconnect.php');

        $id = $_SESSION['id'];
        $sql = "SELECT * FROM user WHERE id=$id ";
        $arr = mysqli_query($dbcon, $sql);

        function redirect()
        {
            echo "<script>";
            echo "window.location.href='login.php'";
            echo "</script>";
        }


        if (mysqli_num_rows($arr) > 0) {
            while ($row = mysqli_fetch_assoc($arr)) {

                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
            }
        } else {
            redirect();
        }
    }
    ?>

</head>

<body>
    <div class="nav-top">
        <div></div>
        <div class="center">
            โปรแกรมคิดเงิน
        </div>
        <div class="right">
            <?php if ($_SESSION) { ?>
                <div class="user">
                    <img src="assets/img/avatar.png" class="avatar" alt="">
                    <span><?php echo $_SESSION['name']; ?></span>
                </div>
                <div class="dropdown-content">
                    <button onclick="edit()">แก้ไขโปรไฟล์</button>

                    <button onclick="logout()">ออกจากระบบ</button>
                </div>
            <?php } else { ?>
                <div>
                    <button onclick="login()" class="login-btn">เข้าสู่ระบบ</button>
                </div>
            <?php } ?>
        </div>
    </div>

    <ul>
        <li><a href="index.php"><i class="fas fa-shopping-cart"></i> &nbsp;หน้าขาย</a></li>
        <li class="active"><a href="stock.php"><i class="fas fa-box"></i> &nbsp;สต๊อกสินค้า</a></li>
        <li><a href="category.php"><i class="fas fa-folders"></i> &nbsp;หมวดหมู่สินค้า</a></li>
        <li><a href="history.php"><i class="fas fa-history"></i> &nbsp;ประวัติการขาย</a></li>
        <li><a href="howto.php"><i class="fas fa-book"></i> &nbsp;คู่มือ</a></li>
    </ul>

    <div id="app">
        <div class="table-product">
            <table style="width: 100%; table-layout: fixed; overflow-wrap: break-word;">
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่สินค้า</th>
                    <th>ราคา</th>
                    <th>คงเหลือ</th>
                </tr>
                <tr v-for="product in products" v-on:click="selectProduct(product.id)" 
                :style="{background: productActive == product.id ? '#2c73d1' : null, color: productActive == product.id ? 'white' : null}">
                    <td>{{product.name}}</td>
                    <td>{{product.category}}</td>
                    <td>{{parseFloat(product.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
                    <td>{{product.remain}}</td>
                </tr>
            </table>
        </div>


        <div class="edit-product">
            <div class="section-img">
                <img :src="imagePreview ? imagePreview : dataProduct.img ? `assets/img/${dataProduct.img}`
                : 'https://upload.wikimedia.org/wikipedia/en/thumb/9/98/Blank_button.svg/1124px-Blank_button.svg.png'" alt="">
                <br>
                <label for="img-upload-file" class="btn-upload">อัพโหลดรูปภาพสินค้า</label>
                <input type="file" id="img-upload-file" style="display: none;" @change="uploadImage" accept="image/*"></input> <br><br>
            </div>
            <div class="section-detail">
                <br>
                <p>ชื่อสินค้า</p>
                <input type="text" class="input-name" v-model="dataProduct.name"> <br>
                <p>หมวดหมู่สินค้า</p>
                <div class="select-wrapper">
                    <select name="" id="" @change="selectCategory" v-model="dataProduct.category">
                        <option value="">ไม่มี</option>
                        <template v-for="category in categoryOptions">
                            <option :value="category.name">
                                {{category.name}}
                            </option>
                        </template>
                    </select>
                </div> <br>
                <p>ราคา</p>
                <input type="number" class="input-price" v-model="dataProduct.price"> <br>
                <p>จำนวนคงเหลือ</p>
                <input type="number" class="input-remain" v-model="dataProduct.remain"> <br><br>
                <button class="btn-edit" v-on:click="editProduct" v-if="dataProduct.id">แก้ไขสินค้า</button>
                <button class="btn-edit" v-on:click="addProduct" v-else>เพิ่มสินค้า</button>
                <button class="btn-delete" v-if="dataProduct.id" @click="deleteProduct">ลบสินค้า</button>
                <button class="btn-reset" v-on:click="resetProduct">รีเซ็ตข้อมูล</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js" integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function logout() {
            window.location.href = 'api/logout.php';
        }

        function login() {
            window.location.href = 'login.php';
        }

        function edit() {
            window.location.href = 'editprofile.php';
        }
    </script>

    <script>
        // ทั้งหมดเขียนด้วย vue ซึ่งทำให้ javascript เขียนได้ง่ายและกระชับมากขึ้น
        const app = new Vue({
            el: '#app',
            // data คือศูนย์รวมตัวแปร
            data: {
                dataProduct: {
                    id: "",
                    img: "",
                    name: "",
                    price: "",
                    remain: "",
                    category: ""
                },
                imagePreview: "",
                products: [],
                productActive: "",
                categoryOptions: []
            },
            mounted() {
                this.getProduct();
                this.getCategory();
            },
            methods: {
                toastrSuccess(text) {
                    Toastify({
                        text,
                        duration: 3000,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        onClick: function() {} // Callback after click
                    }).showToast();
                },
                getCategory() {
                    axios.get('api/category/get.php').then(res => {
                        if (res.data != '') {
                            res = res.data.split('\n');
                            res = res.map(e => {
                                e = e.slice(e.indexOf(')') + 3)
                                e = e.slice(0, e.length - 1)
                                try {
                                    return JSON.parse(e);
                                } catch (e) {
                                    return {};
                                }
                            });
                            res.pop();

                            this.categoryOptions = res;
                        }
                    })
                },
                selectCategory(e) {
                    this.dataProduct.category = e.target.value;
                },
                selectProduct(id) {
                    this.productActive = id;
                    this.imagePreview = "";
                    const sData = this.products[this.products.map(e => e.id).indexOf(id)];
                    this.dataProduct = JSON.parse(JSON.stringify(sData));
                },
                // ดึงข้อมูลมาแสดงในตาราง
                getProduct() {
                    axios.get('api/product/get.php').then(res => {
                        res = res.data.split('\n');
                        res = res.map(e => {
                            e = e.slice(e.indexOf(')') + 3)
                            e = e.slice(0, e.length - 1)
                            try {
                                return JSON.parse(e);
                            } catch (e) {
                                return {};
                            }
                        });
                        res.pop();

                        this.products = res;
                    })
                },
                uploadImage(e) {
                    const file = e.target.files[0];
                    this.imagePreview = URL.createObjectURL(file);
                    this.dataProduct = {
                        ...this.dataProduct,
                        img: file
                    }
                },
                // ส่งข้อมูลไปให้ api เพื่อบันทึกลงฐานข้อมูล
                addProduct() {
                    const formData = new FormData();
                    const {
                        img,
                        name,
                        price,
                        remain,
                        category
                    } = this.dataProduct;

                    // ค่าจากช่อง input
                    formData.append('img', img);
                    formData.append('name', name);
                    formData.append('price', price);
                    formData.append('remain', remain);
                    formData.append('category', category);

                    // axios อธืบายง่ายๆคือ xml เวอร์ชันที่ดีกว่าหลายเท่า
                    axios({
                        method: "POST",
                        url: 'api/product/add.php',
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        data: formData
                    }).then(res => {
                        if (res.data === 'success') {
                            this.resetProduct();
                            this.getProduct();
                            this.imagePreview = "";
                            this.toastrSuccess("เพิ่มข้อมูลสำเร็จ");
                        }
                    })
                },
                // ส่งข้อมูลไปให้ api เพื่อแก้ไขสินค้า
                editProduct() {
                    const formData = new FormData();
                    const {
                        id,
                        img,
                        name,
                        price,
                        remain,
                        category
                    } = this.dataProduct;
                    formData.append('id', id);
                    formData.append('img', img);
                    formData.append('name', name);
                    formData.append('price', price);
                    formData.append('remain', remain);
                    formData.append('category', category);

                    axios({
                        method: "POST",
                        url: 'api/product/edit.php',
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        data: formData
                    }).then(res => {
                        console.log(res.data);
                        if (res.data === 'success') {
                            this.getProduct();
                            this.toastrSuccess("แก้ไขข้อมูลสำเร็จ");
                        }
                    })
                },
                // ลบสินค้า
                deleteProduct() {
                    axios.get(`api/product/delete.php?id=${this.dataProduct.id}`).then(res => {
                        if (res.data === 'success') {
                            this.resetProduct();
                            this.getProduct();
                            this.toastrSuccess("ลบข้อมูลสำเร็จ");
                        }
                    })
                },
                resetProduct() {
                    this.dataProduct = {
                        id: "",
                        img: "",
                        name: "",
                        price: "",
                        remain: "",
                        category: ""
                    }
                }
            }
        })
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมคิดเงิน เทพทัย</title>
    <link rel="stylesheet" href="assets/styles/style.css">
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
        <li class="active"><a href="index.php"><i class="fas fa-shopping-cart"></i> &nbsp;หน้าขาย</a></li>
        <li><a href="stock.php"><i class="fas fa-box"></i> &nbsp;สต๊อกสินค้า</a></li>
        <li><a href="category.php"><i class="fas fa-folders"></i> &nbsp;หมวดหมู่สินค้า</a></li>
        <li><a href="history.php"><i class="fas fa-history"></i> &nbsp;ประวัติการขาย</a></li>
        <li><a href="howto.php"><i class="fas fa-book"></i> &nbsp;คู่มือ</a></li>
    </ul>

    <div id="app">
        <div class="modalPay" v-if="modalPay" @click.self="modalPay = false">
            <div class="box">
                <input type="number" placeholder="จำนวนเงินที่ชำระ .." ref="paid" autofocus>
                <div class="box-btn">
                    <button @click="confirmPay">ยืนยัน</button>
                    <button @click="modalPay = false">ยกเลิก</button>
                </div>
            </div>
        </div>

        <form class="searchBox" @submit.prevent="submitSearch">
            <input type="text" placeholder="ค้นหาสินค้า .." class="formSearch" v-model="textSearch">
            <div class="select-wrapper">
                <select name="" id="" @change="selectCategory">
                    <option value="">หมวดหมู่</option>
                    <template v-for="category in categoryOptions">
                        <option :value="category.name">
                            {{category.name}}
                        </option>
                    </template>
                </select>
            </div>
            <button type="submit" class="btnSubmitSearch">ค้นหา</button>
        </form>

        <div class="product">
            <div class="card" v-for="product in products">
                <div class="count-product" :style="{display: product.count > 0 ? 'flex' : 'none'}">
                    <div>{{product.count}}</div>
                    <div v-on:click="substractProduct(product.id)">ลบ</div>
                </div>
                <div class="img" :style="{background: 'url(assets/img/' + product.img + ') center center / cover'}" v-on:click="addProduct(product.id)"></div>
                <div class="detail" v-on:click="addProduct(product.id)">
                    <strong style="font-size: 20px">{{product.name}}</strong>
                    <span>ราคา: ฿ {{parseFloat(product.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</span>
                </div>
            </div>
        </div>

        <div class="pay">
            <div class="section-banner"></div>
            <div class="section-total">
                <span>ราคารวม</span>
                <span>{{parseFloat(totalPrice).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}} บาท</span>
            </div>
            <button class="btn-pay-submit" v-if="totalPrice > 0" @click="openPayModal">ชำระเงิน</button>
            <button class="btn-pay-clear" @click="clearData" v-if="totalPrice > 0">ล้างข้อมูล</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js" integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        const app = new Vue({
            el: '#app',
            // data คือศูนย์รวมตัวแปร
            data: {
                products: [],
                totalPrice: 0,
                sTotalPrice: 0,
                textSearch: "",
                modalPay: false,
                categoryOptions: [],
                categorySearch: ""
            },
            mounted() {
                this.getProduct();
                this.getCategory();
            },
            methods: {
                // เอาข้อมูลสินค้ามาแสดง
                getProduct() {
                    axios.get('api/product/get.php').then(res => {
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
                            res = res.map(e => ({
                                ...e,
                                count: 0
                            }))
                            this.products = res;
                        }
                    })
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
                            res = res.map(e => ({
                                ...e,
                                count: 0
                            }))
                            this.categoryOptions = res;
                        }
                    })
                },
                selectCategory(e) {
                    this.categorySearch = e.target.value;
                },
                // + เมื่อกดแล้วจะแสดงผลรวมราคา
                addProduct(id) {
                    const sProduct = this.products.filter(e => e.id === id)[0];
                    sProduct.count++;
                    this.totalPrice += parseFloat(sProduct.price);
                    this.sTotalPrice += parseFloat(sProduct.price);
                },
                // - เมื่อกดแล้วจะแสดงผลรวมราคา
                substractProduct(id) {
                    const sProduct = this.products.filter(e => e.id === id)[0];
                    sProduct.count--;
                    this.totalPrice -= parseFloat(sProduct.price);
                    this.sTotalPrice -= parseFloat(sProduct.price);
                },

                submitSearch() {
                    axios(`api/product/search.php?text=${this.textSearch}&category=${this.categorySearch}`).then(res => {
                        try {
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

                            this.products = res.map(e => ({
                                ...e,
                                count: 0
                            }));
                        } catch (e) {
                            this.products = [];
                        }
                        this.totalPrice = 0
                    })
                },
                clearData() {
                    this.totalPrice = 0;
                    this.products.map(e => e.count = 0)
                },
                openPayModal() {
                    const user = '<?php if($_SESSION) echo $_SESSION['name']; else echo "" ?>';
                    if(!user) window.location.href = 'login.php';
                    this.modalPay = true
                    setTimeout(() => this.$refs.paid.focus(), 200)
                },
                confirmPay() {
                    const paid = parseFloat(this.$refs.paid.value);
                    const totalPrice = parseFloat(this.totalPrice);

                    if (!paid || paid <= 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: `ระบุจำนวนเงิน`
                        })
                    } else if (paid - totalPrice < 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: `ต้องจ่ายเงินเพิ่ม ${parseFloat(totalPrice - paid).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')} บาท`
                        })
                    } else {
                        const formData = new FormData();
                        formData.append('id', JSON.stringify(this.products.filter(e => e.count > 0).map(e => e.id)));
                        formData.append('count', JSON.stringify(this.products.filter(e => e.count > 0).map(e => e.count)));
                        formData.append('data', JSON.stringify(this.products.filter(e => e.count > 0)));
                        formData.append('totalPrice', totalPrice);
                        formData.append('paid', paid);
                        formData.append('user', '<?php if($_SESSION) echo $_SESSION['name']; else echo ""; ?>');
                        formData.append('email', '<?php if($_SESSION) echo $_SESSION['email']; else echo ""; ?>');

                        axios({
                            method: "POST",
                            url: 'api/history/add.php',
                            data: formData
                        }).then(res => {
                            if (res.data !== 'error') {
                                Swal.fire({
                                    icon: 'success',
                                    title: `เงินทอน ${parseFloat(paid - totalPrice).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')} บาท`
                                }).then(()=>{
                                    window.open(`bill.php?${res.data}`)
                                })
                                this.products.map(e => e.count = 0)
                                this.modalPay = false
                                this.totalPrice = 0
                                this.paid = 0
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: `เกิดข้อผิดพลาด`,
                                    text: 'โปรดลองอีกครั้งภายหลัง'
                                })
                            }
                        })
                    }
                },
            }
        })
    </script>
</body>

</html>
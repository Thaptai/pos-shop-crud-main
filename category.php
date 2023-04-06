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
        <li><a href="stock.php"><i class="fas fa-box"></i> &nbsp;สต๊อกสินค้า</a></li>
        <li class="active"><a href="category.php"><i class="fas fa-folders"></i> &nbsp;หมวดหมู่สินค้า</a></li>
        <li><a href="history.php"><i class="fas fa-history"></i> &nbsp;ประวัติการขาย</a></li>
        <li><a href="howto.php"><i class="fas fa-book"></i> &nbsp;คู่มือ</a></li>
    </ul>

    <div id="app">
        <div class="table-product">
            <table style="width: 100%; table-layout: fixed; overflow-wrap: break-word;">
                <tr>
                    <th>ชื่อหมวดหมู่</th>
                </tr>
                <tr v-for="category in categories" v-on:click="selectCategory(category.id)" :style="{background: categoryActive == category.id ? '#2c73d1' : null, color: categoryActive == category.id ? 'white' : null}">
                    <td>{{category.name}}</td>
                </tr>
            </table>
        </div>


        <div class="edit-product">
            <div class="section-detail">
                <br>
                <p>ชื่อหมวดหมู่</p>
                <input type="text" class="input-name" v-model="name"> <br><br>
                <button class="btn-edit" v-on:click="editCategory" v-if="id">แก้ไขหมวดหมู่</button>
                <button class="btn-edit" v-on:click="addCategory" v-else>เพิ่มหมวดหมู่</button>
                <button class="btn-delete" v-if="id" @click="deleteCategory">ลบหมวดหมู่</button>
                <button class="btn-reset" v-on:click="resetForm">รีเซ็ตข้อมูล</button>
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
                categories: [],
                categoryActive: "",
                id: "",
                name: ""
            },
            mounted() {
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
                selectCategory(id) {
                    this.categoryActive = id;
                    this.id = id;
                    let sData = this.categories[this.categories.map(e => e.id).indexOf(id)];
                    sData = JSON.parse(JSON.stringify(sData));
                    this.name = sData.name;
                },
                // ดึงข้อมูลมาแสดงในตาราง
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

                            this.categories = res;
                        }
                    })
                },
                // ส่งข้อมูลไปให้ api เพื่อบันทึกลงฐานข้อมูล
                addCategory() {
                    const formData = new FormData();

                    // ค่าจากช่อง input
                    formData.append('name', this.name);

                    // axios อธืบายง่ายๆคือ xml เวอร์ชันที่ดีกว่าหลายเท่า
                    axios({
                        method: "POST",
                        url: 'api/category/add.php',
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        data: formData
                    }).then(res => {
                        if (res.data === 'success') {
                            this.getCategory();
                            this.toastrSuccess("เพิ่มข้อมูลสำเร็จ");
                            this.resetForm();
                        }
                    })
                },
                // ส่งข้อมูลไปให้ api เพื่อแก้ไขสินค้า
                editCategory() {
                    const formData = new FormData();
                    formData.append('id', this.id);
                    formData.append('name', this.name);

                    axios({
                        method: "POST",
                        url: 'api/category/edit.php',
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        data: formData
                    }).then(res => {
                        console.log(res.data);
                        if (res.data === 'success') {
                            this.getCategory();
                            this.toastrSuccess("แก้ไขข้อมูลสำเร็จ");
                        }
                    })
                },
                // ลบสินค้า
                deleteCategory() {
                    axios.get(`api/category/delete.php?id=${this.id}`).then(res => {
                        if (res.data === 'success') {
                            this.getCategory();
                            this.toastrSuccess("ลบข้อมูลสำเร็จ");
                            this.resetForm();
                        }
                    })
                },
                resetForm() {
                    this.name = "";
                    this.id = "";
                    this.categoryActive = "";
                }
            }
        })
    </script>
</body>

</html>
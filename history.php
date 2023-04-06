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
        <li><a href="category.php"><i class="fas fa-folders"></i> &nbsp;หมวดหมู่สินค้า</a></li>
        <li class="active"><a href="history.php"><i class="fas fa-history"></i> &nbsp;ประวัติการขาย</a></li>
        <li><a href="howto.php"><i class="fas fa-book"></i> &nbsp;คู่มือ</a></li>
    </ul>

    <div id="app">
        <div class="table-product">
            <strong>ค้นหาด้วยวันที่</strong> &nbsp;&nbsp;&nbsp;
            <input type="date" @change="findDate">
            <br><br>
            <table style="width: 100%; table-layout: fixed; overflow-wrap: break-word;">
                <tr>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>ราคาสินค้า</th>
                    <th>จำนวนเงินที่จ่าย</th>
                </tr>
                <tr v-for="history in histories" v-on:click="selectHistory(history.id)" :style="{background: historyActive == history.id ? '#2c73d1' : null, color: historyActive == history.id ? 'white' : null}">
                    <td>{{history.time.split(' ')[0]}}</td>
                    <td>{{getTime(history.time.split(' '))}}</td>
                    <td>{{parseFloat(history.totalPrice).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
                    <td>{{parseFloat(history.paid).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
                </tr>
            </table>
        </div>


        <div class="edit-product">
            <div class="section-detail" v-if="detail.id">
                <h2>รายละเอียดคำสั่งซื้อ</h2>
                <span>ราคารวมสินค้า &nbsp;&nbsp;<strong>{{detail.totalPrice}}</strong> บาท</span> <br><br>
                <span>จำนวนเงินที่ชำระ &nbsp;&nbsp;<strong>{{detail.paid}}</strong> บาท</span> <br><br>
                <span>ชื่อผู้ซื้อ &nbsp;&nbsp;<strong>{{detail.user}}</strong></span> <br><br>
                <div v-for="product in detail.products">
                    {{product.name}} x {{product.count}}
                </div> <br><br>
                <button class="btn-delete" @click="deleteHistory">ลบประวัติการขาย</button>
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
                detail: {
                    totalPrice: "",
                    paid: "",
                    products: []
                },
                histories: [],
                sHistories: [],
                historyActive: "",
                // findDate: ""
            },
            mounted() {
                this.getHistory();
            },
            methods: {
                findDate(e) {
                    const findDate = e.target.value;
                    if(findDate == ''){
                        this.histories = this.sHistories;
                        return;    
                    }
                    this.histories = this.sHistories.filter(e => e.time.split(' ')[0] === findDate);
                },
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
                getTime(t) {
                    let time = t[1].split(':');
                    let type = t[2];
                    // time[0] = (parseInt(time[0]) + 6) % 24;
                    return time.join(':') + ' ' + type;
                },
                selectHistory(id) {
                    this.detail = this.histories.find(e => e.id == id);
                    this.historyActive = id;
                },
                // ดึงข้อมูลมาแสดงในตาราง
                getHistory() {
                    axios.get('api/history/get.php').then(res => {
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

                        res.map(e => e.products = JSON.parse(e.products));
                        this.histories = res;
                        this.sHistories = res;
                    })
                },
                deleteHistory() {
                    axios.get(`api/history/delete.php?id=${this.historyActive}`).then(res => {
                        if (res.data === 'success') {
                            this.getHistory();
                            this.toastrSuccess("ลบข้อมูลสำเร็จ");
                            this.resetForm();
                        }
                    })
                },
                resetForm() {
                    this.detail = {
                        totalPrice: "",
                        paid: "",
                        products: []
                    }
                    this.historyActive = '';
                }
            }
        })
    </script>
</body>

</html>
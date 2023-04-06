<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>ใบเสร็จรับเงิน</title>

    <!-- Favicon -->
    <link rel="icon" href="./images/favicon.png" type="image/x-icon" />

    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box" id="app">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <!-- <img src="./images/logo.png" alt="Company logo" style="width: 100%; max-width: 300px" /> -->
                                <h3>โปรแกรมคิดเงิน</h3>
                            </td>

                            <td>
                                รหัสใบแจ้งหนี้ #: {{detail.id}}<br />
                                วันที่: {{detail.time}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{detail.user}}<br />
                                {{detail.email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>วิธีชำระเงิน</td>

                <td>#</td>
            </tr>

            <tr class="details">
                <td>เงินสด</td>

                <td>1000</td>
            </tr>

            <tr class="heading">
                <td>สืนค้า</td>

                <td>ราคา</td>
            </tr>

            <tr class="item" v-for="product in detail.products">
                <td>{{product.name}}</td>

                <td>฿{{parseFloat(product.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
            </tr>

            <tr class="total">
                <td></td>

                <td>ทั้งหมด: ฿{{parseFloat(detail.totalPrice).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
            </tr>

            <tr class="total">
                <td></td>

                <td>จ่าย: ฿{{parseFloat(detail.paid).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
            </tr>

            <tr class="total">
                <td></td>

                <td>เงินทอน: ฿{{(parseFloat(detail.paid) - parseFloat(detail.totalPrice)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}}</td>
            </tr>
        </table>
    </div>

    <br><br> <button class="btn-print" onclick="printBill()">พิมพ์ใบเสร็จ</button>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js" integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const app = new Vue({
            el: '#app',
            data() {
                return {
                    detail: {}
                }
            },
            mounted() {
                const id = window.location.search.split('?')[1];
                axios.get(`api/history/get_id.php?id=${id}`).then(res => {
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

                    this.detail = res[0];
                })
            }
        })

        function printBill() {
            window.print();
        }
    </script>
</body>

</html>
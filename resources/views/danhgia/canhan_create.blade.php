@extends('dashboard')

@section('title', 'Tạo mới Đánh giá, xếp loại')

@section('heading')
    Công chức tạo Phiếu đánh giá
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('phieudanhgia.canhan.store') }}" method="post" id="mauphieudanhgia">
                    @csrf
                    <div class="card card-default">
                        <div class="card-body">
                            {{-- Phần Tiêu đề --}}
                            <table class="table table-borderless">
                                <h6 class="font-italic text-bold text-right">Mẫu số 01</h6>
                                <tbody>
                                    <tr>
                                        <td class="text-center py-0">CỤC THUẾ</td>
                                        <td class="text-center text-bold py-0">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</td>
                                    </tr>
                                    <tr class="px-0">
                                        <td class="text-center text-bold py-0"> THUẾ <u>TỈNH QUẢNG</u> TRỊ</td>
                                        <td class="text-center text-bold py-0"><u>Độc lập - Tự do - Hạnh phúc</u></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <br>
                            <h4 class="text-center text-bold my-0">PHIẾU THEO DÕI, ĐÁNH GIÁ CÔNG CHỨC</h4>
                            <h6 class="text-center align-middle my-0"><i>(Kỳ theo dõi, đánh giá: Quý
                                    <input type="number" class="text-center" id="quy_danh_gia" name="quy_danh_gia"
                                        min="1" max="{{ ceil($thoi_diem_danh_gia->month / 3) }}"
                                        value="{{ ceil($thoi_diem_danh_gia->month / 3) }}"> năm <input type="number"
                                        class="text-center" id="nam_danh_gia" name="nam_danh_gia" min="1"
                                        max="{{ $thoi_diem_danh_gia->year }}" value="{{ $thoi_diem_danh_gia->year }}"
                                        readonly>
                                    )
                                </i></h6>
                            <br>

                            {{-- Phần Thông tin cá nhân --}}
                            <h6>Họ và tên: {{ $user->name }}</h6>
                            <h6>Chức vụ, chức danh: {{ $user->chuc_vu->ten_chuc_vu }}</h6>
                            <h6>Đơn vị công tác: {{ $user->phong->ten_phong }}, {{ $user->don_vi->ten_don_vi }}
                            </h6>
                            <br>

                            {{-- Phần I --}}
                            <h6 class="text-bold">I. KẾT QUẢ THEO DÕI, ĐÁNH GIÁ THEO TIÊU CHÍ CHUNG</h6>
                            {{-- Bảng tiêu chí đánh giá --}}
                            <table id="danh-gia" class="table table-bordered">
                                <colgroup>
                                    <col style="width:4%;">
                                    <col style="width:60%;">
                                    <col style="width:12%;">
                                    <col style="width:12%;">
                                    <col style="width:12%;">
                                </colgroup>
                                <thead class="text-center">
                                    <tr>
                                        <th class="align-middle">TT</th>
                                        <th class="align-middle">Tiêu chí chấm điểm</th>
                                        <th class="align-middle">Điểm tối đa</th>
                                        <th class="align-middle">Điểm do cá nhân tự chấm</th>
                                        <th class="align-middle">Cấp có thẩm quyền đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mau_phieu as $mau_phieu_danh_gia)
                                        @php
                                            if (
                                                $mau_phieu_danh_gia->loai_tieu_chi == 'muc_nho' ||
                                                $mau_phieu_danh_gia->loai_tieu_chi == 'tong_diem'
                                            ) {
                                                $tinh_diem = 0;
                                            } else {
                                                $tinh_diem = 1;
                                            }
                                        @endphp
                                        <tr>
                                            {{-- Cột Số thứ tự --}}
                                            <td class="text-center @if ($tinh_diem == 0) text-bold @endif">
                                                {{ $mau_phieu_danh_gia->tt }}
                                            </td>
                                            {{-- Cột Nội dung tiêu chí --}}
                                            <td class="text-justify @if ($tinh_diem == 0) text-bold @endif">
                                                {{ $mau_phieu_danh_gia->noi_dung }}
                                            </td>
                                            {{-- Cột Điểm tối đa của tiêu chí --}}
                                            <td
                                                class="text-center align-middle @if ($tinh_diem == 0) text-bold @endif">
                                                {{ $mau_phieu_danh_gia->diem_toi_da }}
                                            </td>
                                            {{-- Cột Điểm cá nhân tự chấm --}}
                                            @if ($mau_phieu_danh_gia->loai_tieu_chi != 'phuong_an')
                                                <td class="align-middle @if ($tinh_diem == 0) text-bold @endif">
                                                    <input type="number" id="{{ $mau_phieu_danh_gia->ma_tieu_chi }}"
                                                        name="{{ $mau_phieu_danh_gia->ma_tieu_chi }}"
                                                        value="{{ $mau_phieu_danh_gia->diem_toi_da }}"
                                                        class="text-center form-control pl-4" min="0"
                                                        max="{{ $mau_phieu_danh_gia->diem_toi_da }}" step="0.5"
                                                        onchange="tong_{{ $mau_phieu_danh_gia->tieu_chi_me }}(); tong_tc_900(); tong_cong(); tu_xep_loai();"
                                                        @if ($tinh_diem == 0) readonly @endif>
                                                </td>
                                            @else
                                                {{-- Ghi chú: 
                                                    - Nếu điểm của phương án bằng điểm tối đa của tiêu chí mẹ thì tự đánh dấu vào ô của phương án đó. 
                                                    - Khi điểm của tiêu chí con nào thay đổi thì thực hiện tính toán lại Tổng điểm của tiêu chí mẹ, 
                                                      Tổng điểm của các Mục lớn, Tổng điểm cuối cùng và Tự xếp loại. 
                                                --}}
                                                @php
                                                    $diem_toi_da = $mau_phieu_danh_gia
                                                        ->where('ma_tieu_chi', $mau_phieu_danh_gia->tieu_chi_me)
                                                        ->first()->diem_toi_da;
                                                @endphp
                                            @endif
                                            {{-- Cột Điểm cấp trên đánh giá --}}
                                            <td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>

                            {{-- Mục II --}}
                            <h6 class="text-bold">II. TỔNG HỢP KẾT QUẢ THEO DÕI, ĐÁNH GIÁ CÔNG CHỨC</h6>
                            <table id="tong_hop" class="table table-bordered">
                                <colgroup>
                                    <col style="width:76%;">
                                    <col style="width:12%;">
                                    <col style="width:12%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>1. Điểm tiêu chí chung:</td>
                                        <td class="align-middle text-center text-bold">
                                            <input type="number" id="diem_tieu_chi_chung" name="diem_tieu_chi_chung"
                                                value="30" class="text-center form-control pl-4" min="0"
                                                max="30" step="0.5" readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2. Điểm tiêu chí kết quả thực hiện nhiệm vụ:</td>
                                        <td class="align-middle text-center text-bold">
                                            <input type="number" id="diem_thuc_hien_nhiem_vu"
                                                name="diem_thuc_hien_nhiem_vu" value="70"
                                                class="text-center form-control pl-4" min="0" max="70"
                                                step="0.5" onchange="tong_cong(); tu_xep_loai();">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3. Tổng điểm theo dõi, đánh giá công chức:</td>
                                        <td class="align-middle text-center text-bold">
                                            <input type="number" id="tong_diem_tu_cham" name="tong_diem_tu_cham"
                                                value="100" class="text-center form-control pl-4" min="0"
                                                max="100" step="0.5" readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <h6>4. Ưu điểm:</h6>
                            <textarea id="uu_diem" name="uu_diem" rows="5" style="width: 100%;"></textarea>
                            <br>

                            <h6>5. Hạn chế, khuyết điểm:</h6>
                            <textarea id="khuyet_diem" name="khuyet_diem" rows="5" style="width: 100%;"></textarea>
                            <br>

                            <h6>6. Ý kiến nhận xét của cấp có thẩm quyền theo dõi, đánh giá:</h6>
                            <textarea id="cap_tren_nhan_xet" name="cap_tren_nhan_xet" rows="5" style="width: 100%;" disabled></textarea>
                            <br>

                            {{-- Mục Cá nhân tự xếp loại --}}
                            <h6 class="text-bold">C. Cá nhân tự xếp loại: <i>(Chọn 01 trong 04 ô
                                    tương ứng dưới đây)</i></h6>
                            {{-- Danh sách xếp loại --}}
                            <table class="table table-borderless">
                                <colgroup>
                                    <col style="width:20%;">
                                    <col style="width:5%;">
                                    <col style="width:20%;">
                                    <col style="width:5%;">
                                    <col style="width:20%;">
                                    <col style="width:5%;">
                                    <col style="width:20%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        {{-- Xếp loại A --}}
                                        <td class="text-center">
                                            <input type="radio" name="ca_nhan_tu_xep_loai" value="A"
                                                id="hoan_thanh_xuat_sac" class="form-control">
                                            <b>Hoàn thành suất sắc <br>nhiệm
                                                vụ</b><br>(Từ
                                            {{ $xep_loai->where('ma_xep_loai', 'A')->first()->diem_toi_thieu }}
                                            điểm trở lên)
                                        </td>
                                        <td></td>
                                        {{-- Xếp loại B --}}
                                        <td class="text-center">
                                            <input type="radio" name="ca_nhan_tu_xep_loai" value="B"
                                                id="hoan_thanh_tot" class="form-control">
                                            <b>Hoàn thành tốt <br>nhiệm vụ</b><br>(Từ
                                            {{ $xep_loai->where('ma_xep_loai', 'B')->first()->diem_toi_thieu }}
                                            điểm đến dưới
                                            {{ $xep_loai->where('ma_xep_loai', 'A')->first()->diem_toi_thieu }}
                                            điểm)
                                        </td>
                                        <td></td>
                                        {{-- Xếp loại C --}}
                                        <td class="text-center">
                                            <input type="radio" name="ca_nhan_tu_xep_loai" value="C"
                                                id="hoan_thanh" class="form-control">
                                            <b>Hoàn thành <br>nhiệm vụ<br></b>(Từ
                                            {{ $xep_loai->where('ma_xep_loai', 'C')->first()->diem_toi_thieu }}
                                            điểm đến dưới
                                            {{ $xep_loai->where('ma_xep_loai', 'B')->first()->diem_toi_thieu }}
                                            điểm)
                                        </td>
                                        <td></td>
                                        {{-- Xếp loại D --}}
                                        <td class="text-center">
                                            <input type="radio" name="ca_nhan_tu_xep_loai" value="D"
                                                id="khong_hoan_thanh" class="form-control">
                                            <b>Không hoàn thành <br>nhiệm vụ</b><br>(Dưới
                                            {{ $xep_loai->where('ma_xep_loai', 'C')->first()->diem_toi_thieu }}
                                            điểm trở xuống)
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            {{-- Phần Thông tin Người ký --}}
                            <table class="table table-borderless">
                                <colgroup>
                                    <col style="width:40%;">
                                    <col style="width:20%;">
                                    <col style="width:40%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td class="text-center font-italic py-0">Ngày
                                            {{ $ngay_thuc_hien_danh_gia->day }}
                                            tháng
                                            {{ $ngay_thuc_hien_danh_gia->month }} năm
                                            {{ $ngay_thuc_hien_danh_gia->year }}
                                        </td>
                                        <td class="py-0"></td>
                                        <td class="text-center font-italic py-0">Ngày ... tháng ... năm ...
                                    </tr>
                                    <tr>
                                        <td class="text-center text-bold py-0">CÔNG CHỨC TỰ ĐÁNH
                                            GIÁ
                                            <br><br><br><br><br>
                                            {{ $user->name }}
                                        </td>
                                        <td class="py-0"></td>
                                        <td class="text-center text-bold py-0">
                                            CẤP CÓ THẨM QUYỀN<br>THEO DÕI, ĐÁNH GIÁ
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                    <!-- /.card -->

                    {{-- Nút Lưu --}}
                    <div class="text-right">
                        <button type="submit" class="btn bg-olive text-nowrap mb-2 ml-2 col-1" name="submitForm"
                            value="save">Lưu</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@stop

@section('css')
    <style>
        table.dataTable tbody tr.selected>* {
            box-shadow: inset 0 0 0 9999px rgb(184, 184, 184) !important;
        }
    </style>
@stop

@section('js')
    <!-- jquery-validation -->
    <script src="/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/plugins/jquery-validation/additional-methods.min.js"></script>

    {{-- Tổng điểm của tiêu chí mẹ, Tổng điểm của các Mục lớn, Tổng điểm cuối cùng --}}
    <script>
        function tong_tc_100() {
            let tieu_chi_100 = parseFloat(document.getElementById("tc_100").value);
            let tieu_chi_101 = parseFloat(document.getElementById("tc_101").value);
            let tieu_chi_102 = parseFloat(document.getElementById("tc_102").value);
            tieu_chi_100 = tieu_chi_101 + tieu_chi_102;
            document.getElementById("tc_100").value = tieu_chi_100;
        }

        function tong_tc_200() {
            let tieu_chi_200 = parseFloat(document.getElementById("tc_200").value);
            let tieu_chi_201 = parseFloat(document.getElementById("tc_201").value);
            let tieu_chi_202 = parseFloat(document.getElementById("tc_202").value);
            let tieu_chi_203 = parseFloat(document.getElementById("tc_203").value);
            let tieu_chi_204 = parseFloat(document.getElementById("tc_204").value);
            tieu_chi_200 = tieu_chi_201 + tieu_chi_202 + tieu_chi_203 + tieu_chi_204;
            document.getElementById("tc_200").value = tieu_chi_200;
        }

        function tong_tc_300() {
            let tieu_chi_300 = parseFloat(document.getElementById("tc_300").value);
            let tieu_chi_301 = parseFloat(document.getElementById("tc_301").value);
            let tieu_chi_302 = parseFloat(document.getElementById("tc_302").value);
            let tieu_chi_303 = parseFloat(document.getElementById("tc_303").value);
            let tieu_chi_304 = parseFloat(document.getElementById("tc_304").value);
            tieu_chi_300 = tieu_chi_301 + tieu_chi_302 + tieu_chi_303 + tieu_chi_304;
            document.getElementById("tc_300").value = tieu_chi_300;
        }

        function tong_tc_900() {
            let tieu_chi_900 = parseFloat(document.getElementById("tc_900").value);
            let tieu_chi_100 = parseFloat(document.getElementById("tc_100").value);
            let tieu_chi_200 = parseFloat(document.getElementById("tc_200").value);
            let tieu_chi_300 = parseFloat(document.getElementById("tc_300").value);
            tieu_chi_900 = tieu_chi_100 + tieu_chi_200 + tieu_chi_300;
            document.getElementById("tc_900").value = tieu_chi_900;
            document.getElementById("diem_tieu_chi_chung").value = tieu_chi_900;
        }

        function tong_cong() {
            let tong_cong = parseFloat(document.getElementById("tong_diem_tu_cham").value);
            let diem_tieu_chi_chung = parseFloat(document.getElementById("diem_tieu_chi_chung").value);
            let diem_thuc_hien_nhiem_vu = parseFloat(document.getElementById("diem_thuc_hien_nhiem_vu").value);
            tong_cong = diem_tieu_chi_chung + diem_thuc_hien_nhiem_vu;
            document.getElementById("tong_diem_tu_cham").value = tong_cong;
        }

        // Không được xóa function này
        function tong_() {}
    </script>

    {{-- Tự động xếp loại dựa trên Tổng điểm --}}
    <script>
        let diem_tu_cham;
        tu_xep_loai();

        function tu_xep_loai() {
            let diem_tu_cham = parseFloat(document.getElementById("tong_diem_tu_cham").value);
            let ca_nhan_tu_xep_loai = document.getElementsByName("ca_nhan_tu_xep_loai");
            for (let i = 0, len = ca_nhan_tu_xep_loai.length; i < len; i++) {
                ca_nhan_tu_xep_loai[i].disabled = true;
            }
            if (diem_tu_cham >= {{ $xep_loai->where('ma_xep_loai', 'A')->first()->diem_toi_thieu }}) {
                document.getElementById("hoan_thanh_xuat_sac").checked = true;
                document.getElementById("hoan_thanh_xuat_sac").disabled = false;
            } else if (diem_tu_cham >= {{ $xep_loai->where('ma_xep_loai', 'B')->first()->diem_toi_thieu }}) {
                document.getElementById("hoan_thanh_tot").checked = true;
                document.getElementById("hoan_thanh_tot").disabled = false;
            } else if (diem_tu_cham >= {{ $xep_loai->where('ma_xep_loai', 'C')->first()->diem_toi_thieu }}) {
                document.getElementById("hoan_thanh").checked = true;
                document.getElementById("hoan_thanh").disabled = false;
            } else {
                document.getElementById("khong_hoan_thanh").checked = true;
                document.getElementById("khong_hoan_thanh").disabled = false;
            }
        }
    </script>

    {{-- Kiểm tra dữ liệu đầu vào --}}
    <script>
        $(function() {
            $('#mauphieudanhgia').validate({
                rules: {
                    thang_danh_gia: {
                        required: true,
                        min: 1,
                        max: {{ $thoi_diem_danh_gia->month }},
                    },
                    @php
                        foreach ($mau_phieu as $data) {
                            echo '
                        ' .
                                $data->ma_tieu_chi .
                                ': 
                        {
                            required: true,
                            min: 0,
                            max: ' .
                                $data->diem_toi_da .
                                '
                        },';
                        }
                    @endphp
                },
                messages: {
                    thang_danh_gia: {
                        required: "Vui lòng nhập thông tin",
                        min: "Không nhập số âm",
                        max: "Chưa đến thời điểm đánh giá",
                    },
                    diem_tieu_chi_chung: {
                        required: "Vui lòng nhập thông tin",
                        min: "Không nhập số âm",
                        max: "Lớn hơn điểm tối đa",
                    },
                    diem_thuc_hien_nhiem_vu: {
                        required: "Vui lòng nhập thông tin",
                        min: "Không nhập số âm",
                        max: "Lớn hơn điểm tối đa",
                    },
                    tong_diem_tu_cham: {
                        required: "Vui lòng nhập thông tin",
                        min: "Không nhập số âm",
                        max: "Lớn hơn điểm tối đa",
                    },
                    @php
                        foreach ($mau_phieu as $data) {
                            echo '
                        ' .
                                $data->ma_tieu_chi .
                                ': 
                        {
                            required: true,
                            min: "Không nhập số âm",
                            max: "Lớn hơn điểm tối đa",
                        },';
                        }
                    @endphp
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.align-middle').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@stop

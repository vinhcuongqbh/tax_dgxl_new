@extends('dashboard')

@section('title', 'Thông báo kết quả xếp loại tháng')

@section('heading')
    <form action="{{ route('phieudanhgia.thongbaothang') }}" method="post" id="mauphieudanhgia">
        @csrf
        <div class="d-flex">
            <div class="col-4">
                Thông báo KQXL quý
            </div>
            <div class="d-flex justify-content-end col-8">
                <label for="ma_don_vi" class="h6 mt-2 mx-2">ĐV: </label>
                <select id="ma_don_vi_da_chon" name="ma_don_vi_da_chon" class="form-control custom-select col-6">
                    @foreach ($ds_don_vi as $ds_don_vi)
                        <option value="{{ $ds_don_vi->ma_don_vi }}" @if ($ma_don_vi_da_chon == $ds_don_vi->ma_don_vi) selected @endif>
                            {{ $ds_don_vi->ten_don_vi }}</option>
                    @endforeach
                </select>
                <label for="quy_danh_gia" class="h6 mt-2 mx-2">Quý: </label>
                <input id="quy_danh_gia" name="quy_danh_gia" type="number" min="1" max="4"
                    value="{{ ceil($thoi_diem_danh_gia->month / 3) }}" class="form-control text-center"><label
                    class="h6 mt-2">/</label><input type="number" name="nam_danh_gia"
                    value="{{ $thoi_diem_danh_gia->year }}" class="form-control  text-center">
                <button type="submit" class="btn bg-olive form-control ml-2">Xem</button>
            </div>
        </div>
    </form>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped">
                            <colgroup>
                                <col style="width:5%;">
                                <col style="width:20%;">
                                <col style="width:20%;">
                                <col style="width:10%;">
                                <col style="width:10%;">
                                <col style="width:10%;">
                                <col style="width:15%;">
                                <col style="width:10%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">STT</th>
                                    <th class="text-center align-middle" rowspan="2">Họ và tên</th>
                                    <th class="text-center align-middle" rowspan="2">Chức vụ</th>
                                    <th class="text-center align-middle" colspan="3">Điểm</th>
                                    <th class="text-center align-middle" rowspan="2">Ý kiến nhận xét của cấp có thẩm
                                        quyền</th>
                                    <th class="text-center align-middle" rowspan="2">Ghi chú</th>
                                    <th class="text-center align-middle" style="display: none;" rowspan="2">Phòng</th>
                                    <th class="text-center align-middle" style="display: none;" rowspan="2">Đơn vị</th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle">Tiêu chí chung</th>
                                    <th class="text-center align-middle">Kết quả thực hiện nhiệm vụ</th>
                                    <th class="text-center align-middle">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1 @endphp
                                @foreach ($don_vi as $dv)
                                    @if ($phieu_danh_gia->where('ma_don_vi', $dv->ma_don_vi)->count() > 0)
                                        <tr>
                                            <td class="text-center text-bold bg-olive">{{ $i++ }}</td>
                                            <td class="text-bold bg-olive" colspan="7">{{ $dv->ten_don_vi }}</td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                        </tr>
                                    @endif
                                    @foreach ($phong->where('ma_don_vi_cap_tren', $dv->ma_don_vi) as $ph)
                                        @if ($phieu_danh_gia->where('ma_phong', $ph->ma_phong)->count() > 0)
                                            <tr>
                                                <td class="text-center"></td>
                                                <td class="text-bold" colspan="8">{{ $ph->ten_phong }}</td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;">{{ $dv->ten_phong }}</td>
                                                <td style="display: none;">{{ $dv->ten_don_vi }}</td>
                                            </tr>
                                        @endif
                                        @php $j = 1 @endphp
                                        @foreach ($phieu_danh_gia->where('ma_phong', $ph->ma_phong) as $phieu)
                                            <tr>
                                                <td class="text-center">{{ $j++ }}</td>
                                                <td>{{ $phieu->user->name }}</td>
                                                <td class="text-center">{{ $phieu->chuc_vu->ten_chuc_vu }}</td>
                                                <td class="text-center">{{ $phieu->diem_danh_gia_tieu_chi_chung }}</td>
                                                <td class="text-center">
                                                    {{ $phieu->diem_danh_gia_thuc_hien_nhiem_vu }}</td>
                                                <td class="text-center">{{ $phieu->tong_diem_danh_gia }}</td>
                                                <td class="text-center">{{ $phieu->cap_tren_nhan_xet }}</td>
                                                <td class="text-center">{{ $phieu->ly_do->ly_do }}</td>
                                                <td style="display: none;">{{ $phieu->phong->ten_phong }}</td>
                                                <td style="display: none;">{{ $phieu->don_vi->ten_don_vi }}</td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@stop

@section('css')
@stop

@section('js')
    <!-- Datatable -->
    <script>
        $(function() {
            $("#table").DataTable({
                lengthChange: false,
                searching: true,
                autoWidth: false,
                ordering: false,
                paging: false,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 1000,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'spacer',
                        style: 'bar',
                        text: 'Xuất:'
                    },
                    //'csv',
                    'excel',
                    'pdf',
                ],
                language: {
                    url: '/plugins/datatables/vi.json'
                },
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop

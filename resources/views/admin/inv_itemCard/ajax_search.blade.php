@if (@isset($data) && !@empty($data))
            <div id="ajax_response_searchDiv">
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="custom_thead">
                        <th>مسلسل</th>
                        <th>الاسم</th>
                        <th>النوع</th>
                        <th>الفئة</th>
                        <th>الصنف الاب</th>
                        <th>الوحدة الاب</th>
                        <th>الوحدة التجزئة</th>
                        <th>حالة التفعيل</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $info)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $info->name }}</td>
                                <td>
                                    @if ($info->item_type ==1)
                                    مخزنى
                                    @elseif ($info->item_type ==2)
                                    استهلاكى
                                    @elseif($info->item_type ==3)
                                    عهده
                                    @else
                                    غير محدد
                                    @endif
                                </td>
                                <td>{{ $info->inv_itemcard_categories_name }}</td>
                                <td>{{ $info->parent_item_name }}</td>
                                <td>{{ $info->uom_name }}</td>
                                <td>{{ $info->retail_uom_name }}</td>
                                <td>
                                    @if ($info->active ==1)
                                    مفعلة
                                    @else
                                    معطلة
                                    @endif
                                </td>


                                <td>
                                    <a href="{{ route('admin.itemCard.edit',$info->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                    <a onclick="return confirm('هل متأكد من حذف الصنف؟')" href="{{ route('admin.itemCard.delete',$info->id) }}"class="btn btn-danger btn-sm">حذف</a>
                                    <a href="{{ route('admin.itemCard.show',$info->id) }}" class="btn btn-info btn-sm">عرض</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="col-md-12" id="ajax_pagination_in_search">
                    {{ $data->links() }}
                </div>
            </div>
            @else
            <div class="alert alert-danger">
                عفوا لا توجد بيانات لعرضها
            </div>
            @endif

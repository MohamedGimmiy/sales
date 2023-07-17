@if (@isset($data) && !@empty($data))
            <div id="ajax_response_searchDiv">
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="custom_thead">
                        <th>مسلسل</th>
                        <th>اسم الوحدة</th>
                        <th>هل رئيسية</th>
                        <th>نوع الوحدة</th>
                        <th>حالة التفعيل</th>
                        <th>تاريخ الاضافة</th>
                        <th>تاريخ التحديث</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $info)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $info->name }}</td>
                                <td>
                                    @if ($info->is_master ==1)
                                    وحدة اب
                                    @else
                                    وحدة تجزئة
                                    @endif
                                </td>
                                <td>
                                    @if ($info->active ==1)
                                    مفعلة
                                    @else
                                    معطلة
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $dt = new DateTime($info['created_at']);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i');
                                        $newDateTime = date("A",strtotime($time));
                                        $newDateTimeType = (($newDateTime == 'AM')? 'صباحا' : 'مساءا')
                                    @endphp
                                    {{ $date }}
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    بواسطة
                                    {{ $info['added_by_admin'] }}
                            </td>
                            <td>
                                @if ($info['updated_by'] > 0 and $info['updated_by'] != null)
                                    @php
                                        $dt = new DateTime($info['updated_at']);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i');
                                        $newDateTime = date("A",strtotime($time));
                                        $newDateTimeType = (($newDateTime == 'AM')? 'صباحا' : 'مساءا')
                                    @endphp
                                    {{ $date }}
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    بواسطة
                                    {{ $data['updated_by_admin'] }}
                                @else
                                لا يوجد تحديث
                                @endif
                            </td>
                                <td>
                                    <a href="{{ route('admin.uoms.edit',$info->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                    <a onclick="return confirm('هل متأكد من حذف الوحدة؟')" href="{{ route('admin.uoms.delete',$info->id) }}"class="btn btn-danger btn-sm">حذف</a>
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

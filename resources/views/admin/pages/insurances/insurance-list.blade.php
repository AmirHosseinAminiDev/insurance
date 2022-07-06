<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h3 class="text-right text-black">لیست بیمه ها</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">کد بیمه</th>
                        <th scope="col">نام بیمه</th>
                        <th scope="col">تاریخ ایجاد</th>
                        <th scope="col">آخرین ویرایش</th>
                        <th class="text-left" scope="col">عمل</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($insurancesList as $insurance)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $insurance->insurance_code }}</td>
                            <td>{{ $insurance->name ?? '' }}</td>
                            <td>{{ \Morilog\Jalali\Jalalian::forge($insurance->created_at)->format('Y/m/d') ?? '' }}</td>
                            <td>{{ \Morilog\Jalali\Jalalian::forge($insurance->updated_at)->format('Y/m/d') ?? '' }}</td>
                            <td class="text-left">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-light btn-floating btn-icon btn-sm"
                                       data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="d-none" id="delete-{{ $insurance->id }}-insurance"
                                              action="{{ route('insurance.destory',$insurance) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a class="dropdown-item"
                                           href="{{ route('insurance.edit',$insurance) }}">ویرایش</a>
                                        <a class="dropdown-item"
                                           onclick="return confirm('آیا مطمئن هستید؟') ? document.getElementById('delete-{{ $insurance->id }}-insurance').submit() : ''"
                                           href="#">حذف</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $insurancesList->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

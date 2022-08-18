<div class="user-list-sec container-lg px-3 mt-5">
    <div class="col-sm-12 col-lg-10 m-auto">
        <h3 class="text-center text-primary text-[24px] fw-bold">Payment Link Plan</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('payment.link.payment') }}" method="POST" class="p-3">
        @csrf
        <div class="card border-white p-lg-5 p-4 mt-5 ">
                <div class="row d-flex justify-content-between px-0">
                    <div class="col-sm-12 col-md-4 pe-3 mb-3">
                        <label class="user-list-label fw-bold mb-2">Plan</label>
                        <select class="form-select" name="type">
                            <option selected></option>
                            @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}"> {{ $plan->name }} - {{ $plan->price }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row col-md-6 col-8 mt-5 m-auto btn-box">
                    <button type="submit" class="border-0 text-white btn btn-primary rounded-pill fw-bold btn-lg">Pay</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="appBottomMenu">
    <a a href="{{url('/')}}" class="item @if(Request::segment(1) == '') active @endif">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a a href="#" class="item ">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                aria-label="calendar outline"></ion-icon>
            <strong>Calendar</strong>
        </div>
    </a>
    <a a href="{{url('/absensi')}}" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a a href="#" class="item">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Docs</strong>
        </div>
    </a>
    <a href="javascript:;" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
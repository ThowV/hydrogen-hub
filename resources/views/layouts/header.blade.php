<div class="h-24 grid grid-col-2 grid-rows-2 font-bold">
    <div class="col-start-1 flex flex-row items-baseline py-8 xxl:py-10">
        <h1 class="text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">
            @isset($title)
                {{ ucfirst($title) }}
            @else
                MISSING TITLE
            @endisset
        </h1>
        <h2 class="text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
    </div>
    <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
        <h3 id="date-time" class="text-xs xxl:text-xl text-gray-600"></h3>
    </div>
</div>

<script>
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    let date = new Date();
    let dateString = `${days[date.getDay()]} ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    let minutesString = date.getMinutes() < 10 ? `0${date.getMinutes()}` : `${date.getMinutes()}`;

    let timer = setInterval(function() {
        let date = new Date();
        let secondsString = date.getSeconds() < 10 ? `0${date.getSeconds()}` : `${date.getSeconds()}`;
        let timeString = `${date.getHours()}:${minutesString}:${secondsString}`;

        document.getElementById("date-time").innerHTML = `${dateString} | ${timeString}`;
    }, 1000);
</script>

document.addEventListener("DOMContentLoaded", function () {

    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {

        const target = Number(counter.getAttribute("data-target"));
        let count = 0;

        const updateCounter = () => {

            if (count < target) {
                count++;
                counter.innerText = count;
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target;
            }

        };

        updateCounter();

    });

});

function updateTimers() {

    let rows = document.querySelectorAll("#vehicleTable tbody tr");

    rows.forEach(row => {

        let timer = row.querySelector(".timer");
        let feeCell = row.querySelector(".fee");

        // Get time from PHP
        let rawTime = timer.dataset.time;

        // Convert MySQL datetime to JS datetime
        let start = new Date(rawTime.replace(" ", "T"));
        let now = new Date();

        let diff = Math.floor((now - start) / 1000);

        if (isNaN(diff) || diff < 0) {
            diff = 0;
        }

        let minutes = Math.floor(diff / 60);
        let seconds = diff % 60;

        timer.innerText =
            minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);

        // ₱50 first minute, then +₱50 every 2 minutes
         let fee = (Math.floor(diff / 120) + 1) * 10;
        feeCell.innerText = "₱ " + fee;

        // DEBUG
        console.log("Raw Time:", rawTime);
        console.log("Start:", start);
        console.log("Diff:", diff);
        console.log("Fee:", fee);

    });

}

setInterval(updateTimers, 1000);
updateTimers();

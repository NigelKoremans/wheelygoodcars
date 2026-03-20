<div>
    <div class="border-2 border-black bg-yellow-500 h-20 w-100 flex rounded-lg mt-2">
        <div class="bg-blue-500 px-1 pt-4 pb-2 w-8 h-full rounded-l-lg">
            <img class="select-none" src="{{ asset('images/euro_stars.png')}}" alt="de twaalf gouden sterren van de europese unie.">
            <p class="text-white text-center">NL</p>
        </div>
        <div class="h-full flex pl-12 items-center">
            <input id="plate" value="{{ $plate }}" required class="pb-1 text-6xl w-70 uppercase outline-0 text-shadow-[0_0_3px,0_0_3px,0_0_3px,0_0_3px] text-shadow-yellow-700" maxlength="8" type="text" placeholder="AA-BB-12">
            <input type="hidden" name="plate" id="platehidden" value="{{ $plate }}">
            <input class="text-xl hover:text-white" type="submit" value="Go!">
        </div>
    </div>
    <script>
        const plateInput = document.getElementById("plate")
        const plateHidden = document.getElementById("platehidden")

        plateInput.addEventListener("input", function(e) {
            e.preventDefault();
            const targetValue = e.target.value;

            const cleanValue = targetValue.replace(/[^a-zA-Z0-9]/g, "");

            if (cleanValue.length > 6) {
                let formatted = plateHidden.value.replace(/([a-zA-Z])(?=[0-9])/g, "$1-");
                plateInput.value = formatted.replace(/([0-9])(?=[a-zA-Z])/g, "$1-");
                return;
            }

            plateHidden.value = cleanValue;

            console.log(cleanValue.length);

            let formatted = cleanValue.replace(/([a-zA-Z])(?=[0-9])/g, "$1-");
            formatted = formatted.replace(/([0-9])(?=[a-zA-Z])/g, "$1-");

            plateHidden.value = cleanValue;
            plateInput.value = formatted;
        })

        let formatted = plateHidden.value.replace(/([a-zA-Z])(?=[0-9])/g, "$1-");
        plateInput.value = formatted.replace(/([0-9])(?=[a-zA-Z])/g, "$1-");
    </script>
</div>

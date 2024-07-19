<template>
    <div class="relative flex flex-col min-w-0 break-words bg-white rounded border mb-6 xl:mb-0 shadow-lg">
        <div class="flex-auto p-4">
            <div class="flex flex-row box-content relative">
                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                    <h5 class="text-gray-800 uppercase  font-bold text-xs">
                        {{ statSubtitle }}
                    </h5>
                    <span class="font-semibold text-xl text-gray-700">
                        {{ statTitle }}
                    </span>
                </div>
                <div class="relative w-auto pl-4 flex-initial">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full"
                        :class="[statIconColor]">
                        <font-awesome-icon :icon="statIconName"/>
                    </div>
                </div>
            </div>
            <!-- <p class="text-sm text-gray-400 mt-4">
                <span class="mr-2" :class="[statPercentColor]">
                    <font-awesome-icon :icon="statArrow === 'up' ? [`fas`,`fa-arrow-up`] : [`fas`,`fa-arrow-down`]"/>
                    {{ statPercent }}%
                </span>
                <span class="whitespace-nowrap">{{ statDescripiron }}</span>
            </p> -->
        </div>
    </div>
</template>
<script>
export default {
    name: "card-stats",
    props: {
        statSubtitle: {
            type: String,
            default: "Traffic",
        },
        statTitle: {
            type: Number,
            default: 0,
        },
        statArrow: {
            default: "up",
            validator: function (value) {
                // The value must match one of these strings
                return ["up", "down"].indexOf(value) !== -1;
            },
        },
        statPercent: {
            type: String,
            default: "3.48",
        },
        // can be any of the text color utilities
        // from tailwindcss
        statPercentColor: {
            type: String,
            default: "text-emerald-500",
        },
        statDescripiron: {
            type: String,
            default: "Since last month",
        },
        statIconName: {
            type: Array,
            default: ["far","fa-chart-bar"],
        },
        // can be any of the background color utilities
        // from tailwindcss
        statIconColor: {
            type: String,
            default: "bg-red-500",
        },
    },
};
</script>

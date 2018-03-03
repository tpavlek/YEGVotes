<template>
    <div class="bg-white shadow border text-left h-48 max-w-sm flex flex-row m-2 flex-grow">
        <div :style="{ 'background-image': 'url(' + imageUrl + ')', width: '12em'}" style="background-size:cover; background-position:center;">

        </div>

        <div class="flex flex-grow flex-col h-full">
            <span class="p-2">
                <span class="text-xl font-extrabold">{{ councilMemberName }}</span>
                <small class="font-normal text-normal" v-show="!isMayor">{{ councilMemberWard }}</small>
            </span>
            <div class="flex-grow leading-loose p-2">
                <slot></slot>
            </div>

            <a :href="linkUrl" class="p-2 bg-grey-lighter hover:bg-grey-light no-underline">
                <span class="text-grey-darkest"><i class="fa fa-check"></i> Voting Record</span>
            </a>

        </div>

    </div>
</template>

<script>
    export default {
        props: ['imageUrl', 'linkUrl', 'councilMemberName', 'councilMemberWard'],
        computed: {
            isMayor: () => this.councilMemberWard == 'Mayor'
        }
    }
</script>

<style></style>

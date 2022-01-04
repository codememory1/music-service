<template>
	<music-item author="Danil" name="csdcsdc" image="/public/images/track1.png"/>
</template>

<script>
import BaseCalendar from "../../components/BaseCalendarComponent";
import MusicItem from "../../components/MusicItemComponent";

export default {
  name: "TestView",
  components: {
	MusicItem
  }
}
</script>
<div class="mt-4">
    <x-input-label for="xp_cost" :value="__('XP Cost (1-100)')" />
    <x-text-input id="xp_cost" class="block mt-1 w-full" type="number" name="xp_cost" :value="old('xp_cost', $player->xp_cost)" required min="1" max="100" />
    <x-input-error :messages="$errors->get('xp_cost')" class="mt-2" />
</div> 
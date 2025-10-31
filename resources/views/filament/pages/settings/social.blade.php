<x-filament-forms::field-wrapper label="Facebook URL" statePath="social_fb_link" hint="Enter your Facebook page URL">
    <input type="url" id="social_fb_link" name="social_fb_link"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="https://facebook.com/yourpage" value="{{ old('social_fb_link', $settings['social_fb_link'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Twitter URL" statePath="social_twiter_link" hint="Enter your Twitter profile URL">
    <input type="url" id="social_twiter_link" name="social_twiter_link"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="https://twitter.com/yourhandle" value="{{ old('social_twiter_link', $settings['social_twiter_link'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Instagram URL" statePath="social_inst_link"
    hint="Enter your Instagram profile URL">
    <input type="url" id="social_inst_link" name="social_inst_link"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="https://instagram.com/yourhandle"
        value="{{ old('social_inst_link', $settings['social_inst_link'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="LinkedIn URL" statePath="social_linkedin" hint="Enter your LinkedIn profile URL">
    <input type="url" id="social_linkedin" name="social_linkedin"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="https://linkedin.com/company/yourcompany"
        value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" />
</x-filament-forms::field-wrapper>

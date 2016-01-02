Add to onbootstrap event:

        /**
         * Affiliate programme runs from here
         */
        $referrerValidator = new ReferrerValidator();
        $referrerValidator->validate();
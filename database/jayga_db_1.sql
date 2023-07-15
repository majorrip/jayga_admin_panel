CREATE TABLE "saftey_measure"(
    "listing_id" BIGINT NOT NULL,
    "smoke_alarm" BIGINT NOT NULL,
    "first_aid_kit" BIGINT NOT NULL,
    "fire_extinguisher" BIGINT NOT NULL,
    "CO_alarm" BIGINT NOT NULL
);
ALTER TABLE
    "saftey_measure" ADD CONSTRAINT "saftey_measure_listing_id_primary" PRIMARY KEY("listing_id");
CREATE TABLE "lister_dashboard"(
    "lister_id" BIGINT NOT NULL,
    "earnings" BIGINT NOT NULL,
    "past_booking" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "lister_dashboard" ADD CONSTRAINT "lister_dashboard_lister_id_primary" PRIMARY KEY("lister_id");
CREATE TABLE "lister_user"(
    "lister_id" INT NOT NULL,
    "user_id" BIGINT NOT NULL,
    "lister_email" VARCHAR(255) NOT NULL,
    "lister_phone_num" VARCHAR(255) NOT NULL,
    "lister_nid" VARCHAR(255) NOT NULL,
    "lister_dob" DATE NOT NULL,
    "lister_address" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "lister_user" ADD CONSTRAINT "lister_user_lister_id_primary" PRIMARY KEY("lister_id");
CREATE TABLE "user_pictures"(
    "user_picture_id" BIGINT NOT NULL,
    "user_id" BIGINT NOT NULL,
    "user_filename" BIGINT NOT NULL,
    "user_targetlocation" BIGINT NOT NULL
);
ALTER TABLE
    "user_pictures" ADD CONSTRAINT "user_pictures_user_picture_id_primary" PRIMARY KEY("user_picture_id");
CREATE TABLE "time_slot_shortstays"(
    "time_id" BIGINT NOT NULL,
    "times" BIGINT NOT NULL
);
ALTER TABLE
    "time_slot_shortstays" ADD CONSTRAINT "time_slot_shortstays_time_id_primary" PRIMARY KEY("time_id");
CREATE TABLE "restriction"(
    "listing_id" BIGINT NOT NULL,
    "indoor_smoke" BIGINT NOT NULL,
    "host_parties" BIGINT NOT NULL,
    "pets" BIGINT NOT NULL,
    "un_vaccinated" BIGINT NOT NULL,
    "late_night_entry" BIGINT NOT NULL,
    "unknown_guest" BIGINT NOT NULL,
    "anything_specific" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "restriction" ADD CONSTRAINT "restriction_listing_id_primary" PRIMARY KEY("listing_id");
CREATE TABLE "amenities"(
    "listing_id" BIGINT NOT NULL,
    "wifi" BIGINT NOT NULL,
    "tv" BIGINT NOT NULL,
    "kitchen" BIGINT NOT NULL,
    "washer" BIGINT NOT NULL,
    "free_parking" BIGINT NOT NULL,
    "paid_parking" BIGINT NOT NULL,
    "air_cond" BIGINT NOT NULL,
    "dedicated_workspace" BIGINT NOT NULL,
    "pool" BIGINT NOT NULL,
    "hottub" BIGINT NOT NULL,
    "patio" BIGINT NOT NULL,
    "bbq_grill" BIGINT NOT NULL,
    "outdoor_dining area" BIGINT NOT NULL,
    "fire_pit" BIGINT NOT NULL,
    "gym" BIGINT NOT NULL,
    "beach_access" BIGINT NOT NULL
);
ALTER TABLE
    "amenities" ADD CONSTRAINT "amenities_listing_id_primary" PRIMARY KEY("listing_id");
CREATE TABLE "listing"(
    "listing_id" BIGINT NOT NULL,
    "lister_id" BIGINT NOT NULL,
    "guest_num" BIGINT NOT NULL,
    "bed_num" BIGINT NOT NULL,
    "bathroom_num" BIGINT NOT NULL,
    "title" VARCHAR(255) NOT NULL,
    "short_stay" VARCHAR(255) NOT NULL,
    "describe_peaceful" BIGINT NOT NULL,
    "describe_unique" BIGINT NOT NULL,
    "describe_familyfriendly" BIGINT NOT NULL,
    "describe_stylish" BIGINT NOT NULL,
    "describe_central" BIGINT NOT NULL,
    "describe_spacious" BIGINT NOT NULL,
    "full_day_price_set_by_user" BIGINT NOT NULL,
    "short_stay_price_set_up_by_user" BIGINT NULL,
    "short_stay_price_set_up_by_jayga" BIGINT NULL,
    "address" VARCHAR(255) NOT NULL,
    "district" VARCHAR(255) NOT NULL,
    "zip_code" BIGINT NOT NULL,
    "town" VARCHAR(255) NOT NULL,
    "bathroom_private" VARCHAR(255) NOT NULL,
    "breakfast_availability" VARCHAR(255) NOT NULL,
    "description" VARCHAR(255) NOT NULL,
    "room_lock" VARCHAR(255) NOT NULL,
    "who_else_might_be_there" VARCHAR(255) NOT NULL,
    "house" BIGINT NOT NULL,
    "appartment" BIGINT NOT NULL,
    "rooms" BIGINT NOT NULL
);
ALTER TABLE
    "listing" ADD CONSTRAINT "listing_listing_id_primary" PRIMARY KEY("listing_id");
CREATE TABLE "review"(
    "review_id" BIGINT NOT NULL,
    "user_id" BIGINT NOT NULL,
    "user_name" BIGINT NOT NULL,
    "lister_id" BIGINT NOT NULL,
    "lister_name" BIGINT NOT NULL,
    "stars" BIGINT NOT NULL,
    "description" BIGINT NOT NULL
);
ALTER TABLE
    "review" ADD CONSTRAINT "review_review_id_primary" PRIMARY KEY("review_id");
CREATE TABLE "review_images"(
    "review_image_id" BIGINT NOT NULL,
    "review_id" BIGINT NOT NULL,
    "review_filename" BIGINT NOT NULL,
    "review_tragetlocation" BIGINT NOT NULL
);
ALTER TABLE
    "review_images" ADD CONSTRAINT "review_images_review_image_id_primary" PRIMARY KEY("review_image_id");
CREATE TABLE "booking"(
    "booking_id" BIGINT NOT NULL,
    "user_id" BIGINT NOT NULL,
    "listing_id" BIGINT NOT NULL,
    "lister_id" BIGINT NOT NULL,
    "time_flag" BIGINT NULL,
    "time_id" BIGINT NOT NULL,
    "all_day_flag" BIGINT NOT NULL,
    "days_stayed" INT NULL,
    "date_enter" DATE NOT NULL,
    "date_exit" DATE NOT NULL,
    "pay_amount" BIGINT NOT NULL,
    "payment_flag" BIGINT NOT NULL,
    "api stuff" BIGINT NOT NULL
);
ALTER TABLE
    "booking" ADD CONSTRAINT "booking_booking_id_primary" PRIMARY KEY("booking_id");
CREATE TABLE "users"(
    "user_id" INT NOT NULL,
    "user_name" VARCHAR(255) NOT NULL,
    "user_email" VARCHAR(255) NOT NULL,
    "user_phone_num" BIGINT NOT NULL,
    "user_nid" BIGINT NOT NULL,
    "user_dob" DATE NOT NULL,
    "user_address" VARCHAR(255) NOT NULL,
    "is_lister" BIGINT NULL,
    "FCM_token" BIGINT NULL
);
ALTER TABLE
    "users" ADD CONSTRAINT "users_user_id_primary" PRIMARY KEY("user_id");
CREATE TABLE "lister_pictures"(
    "lister_id" BIGINT NOT NULL,
    "lister_filename" BIGINT NOT NULL,
    "lister_targetlocation" BIGINT NOT NULL
);
ALTER TABLE
    "lister_pictures" ADD CONSTRAINT "lister_pictures_lister_id_primary" PRIMARY KEY("lister_id");
CREATE TABLE "listing_images"(
    "listing_img_id" BIGINT NOT NULL,
    "listing_id" BIGINT NOT NULL,
    "listing_filename" BIGINT NOT NULL,
    "listing_targetlocation" BIGINT NOT NULL
);
ALTER TABLE
    "listing_images" ADD CONSTRAINT "listing_images_listing_img_id_primary" PRIMARY KEY("listing_img_id");
CREATE TABLE "lister_nid"(
    "listing_nid_id" BIGINT NOT NULL,
    "lister_nid_pic_name" BIGINT NOT NULL,
    "listing_nid_pic_loaction" BIGINT NOT NULL
);
ALTER TABLE
    "lister_nid" ADD CONSTRAINT "lister_nid_listing_nid_id_primary" PRIMARY KEY("listing_nid_id");
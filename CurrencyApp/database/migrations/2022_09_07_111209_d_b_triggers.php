<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        #rates duplicate trigger
        DB::unprepared('DROP TRIGGER IF EXISTS `rates_duplicate_trigger`');
        DB::unprepared("CREATE TRIGGER rates_duplicate_trigger
            BEFORE INSERT ON rates
            FOR EACH ROW
            BEGIN

                IF (EXISTS(SELECT 1 FROM rates WHERE time = NEW.time AND vendor_id  = NEW.vendor_id
                        AND parity_id  = NEW.parity_id )) THEN
                    SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT = 'INSERT failed due to duplicated rates';
                END IF;
            END
        ");
        #parities duplicate trigger
        DB::unprepared('DROP TRIGGER IF EXISTS `parities_duplicate_trigger`');
        DB::unprepared("CREATE TRIGGER parities_duplicate_trigger
            BEFORE INSERT ON parities
            FOR EACH ROW
            BEGIN

                IF (EXISTS(SELECT 1 FROM parities WHERE code = NEW.code AND vendor_id  = NEW.vendor_id
                )) THEN
                    SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT = 'INSERT failed due to duplicated parity';
                END IF;
            END
        ");

        #preferences

        DB::unprepared('DROP TRIGGER IF EXISTS `user_preferences_duplicate_trigger`');
        DB::unprepared("CREATE TRIGGER user_preferences_duplicate_trigger
            BEFORE INSERT ON user_preferences
            FOR EACH ROW
            BEGIN

                IF (EXISTS(SELECT 1 FROM user_preferences WHERE user_id = NEW.user_id AND vendor_id  = NEW.vendor_id
                        AND parity_id  = NEW.parity_id )) THEN
                    SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT = 'INSERT failed due to duplicated rates';
                END IF;
            END
        ");

        #preferences fill
        DB::unprepared('DROP TRIGGER IF EXISTS `user_preferences_trigger`');
        DB::unprepared("CREATE TRIGGER user_preferences_trigger

                    AFTER INSERT ON users
                        FOR EACH ROW
                        BEGIN

                        INSERT INTO  user_preferences
                        (user_id, vendor_id, parity_id)
                           select users.id,parities.vendor_id,parities.id
                            from users,parities
                            where users.id =NEW.id and parities.id IN (
                                SELECT parities.id
                                FROM parities
                                group by parities.code
                            );



                    END

        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('rates_duplicate_trigger');
        Schema::dropIfExists('parities_duplicate_trigger');
        Schema::dropIfExists('user_preferences_trigger');
        Schema::dropIfExists('user_preferences_duplicate_trigger');



    }
};

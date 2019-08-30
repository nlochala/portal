<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\GradeLevel
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $short_name
 * @property string|null $name
 * @property int|null $year_id
 * @property int|null $school_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @property-read \App\User|null $createdBy
 * @property-read \App\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read \App\User|null $updatedBy
 * @property-read \App\Year $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel current()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeLevel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeLevel whereYearId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeLevel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeLevel withoutTrashed()
 */
	class GradeLevel extends \Eloquent {}
}

namespace App{
/**
 * App\FileAudit
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $file_id
 * @property int|null $person_id
 * @property string|null $download_date
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\FileAudit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereDownloadDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileAudit whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileAudit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\FileAudit withoutTrashed()
 */
	class FileAudit extends \Eloquent {}
}

namespace App{
/**
 * App\PositionType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PositionType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PositionType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PositionType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PositionType withoutTrashed()
 */
	class PositionType extends \Eloquent {}
}

namespace App{
/**
 * App\EmployeeClassification
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $base_allowance
 * @property int|null $housing_allowance
 * @property int|null $medical_insurance_allowance
 * @property int|null $social_insurance_allowance
 * @property int|null $medical_covered
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read mixed $combined_name
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeClassification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereBaseAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereHousingAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereMedicalCovered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereMedicalInsuranceAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereSocialInsuranceAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeClassification whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeClassification withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeClassification withoutTrashed()
 */
	class EmployeeClassification extends \Eloquent {}
}

namespace App{
/**
 * App\GradeScaleStandard
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $short_name
 * @property string|null $name
 * @property string|null $description
 * @property int|null $grade_scale_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\GradeScale $gradeScale
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScaleStandard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereGradeScaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScaleStandard whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScaleStandard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScaleStandard withoutTrashed()
 */
	class GradeScaleStandard extends \Eloquent {}
}

namespace App{
/**
 * App\GradeScalePercentage
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $grade_scale_id
 * @property int|null $from
 * @property int|null $to
 * @property string|null $result
 * @property int|null $equivalent_standard_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\GradeScale $gradeScale
 * @property-read \App\GradeScaleStandard $standard
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScalePercentage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereEquivalentStandardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereGradeScaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScalePercentage whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScalePercentage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScalePercentage withoutTrashed()
 */
	class GradeScalePercentage extends \Eloquent {}
}

namespace App{
/**
 * App\EmployeeBonus
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $employee_bonus_type_id
 * @property int|null $employee_id
 * @property int|null $bonus_weight
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereBonusWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereEmployeeBonusTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonus whereUuid($value)
 */
	class EmployeeBonus extends \Eloquent {}
}

namespace App{
/**
 * App\AttendanceDay
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $date
 * @property int|null $student_id
 * @property int|null $attendance_type_id
 * @property int|null $quarter_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \App\User|null $createdBy
 * @property-read \App\Student|null $student
 * @property-read \App\AttendanceType|null $type
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay absent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay date($date = 'Y-m-d')
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceDay onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay present()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereAttendanceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereQuarterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceDay whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceDay withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceDay withoutTrashed()
 */
	class AttendanceDay extends \Eloquent {}
}

namespace App{
/**
 * App\PhoneType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PhoneType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhoneType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PhoneType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PhoneType withoutTrashed()
 */
	class PhoneType extends \Eloquent {}
}

namespace App{
/**
 * App\Position
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $school_id
 * @property int|null $position_type_id
 * @property int|null $supervisor_position_id
 * @property int|null $base_weight
 * @property int|null $stipend
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @property-read string $formatted_stipend
 * @property-read \App\School|null $school
 * @property-read \App\Position|null $supervisor
 * @property-read \App\PositionType|null $type
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Position onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereBaseWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position wherePositionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereStipend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereSupervisorPositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Position withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Position withoutTrashed()
 */
	class Position extends \Eloquent {}
}

namespace App{
/**
 * App\School
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\School onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\School whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\School withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\School withoutTrashed()
 */
	class School extends \Eloquent {}
}

namespace App{
/**
 * App\IdCard
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $person_id
 * @property int|null $front_image_file_id
 * @property int|null $back_image_file_id
 * @property int|null $is_active
 * @property string|null $number
 * @property string|null $name
 * @property mixed $issue_date
 * @property mixed $expiration_date
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\File $backImage
 * @property-read \App\User|null $createdBy
 * @property-read \App\File $frontImage
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\IdCard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereBackImageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereFrontImageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdCard whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IdCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\IdCard withoutTrashed()
 */
	class IdCard extends \Eloquent {}
}

namespace App{
/**
 * App\EmployeeStatus
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $base_weight
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereBaseWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeStatus whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeStatus withoutTrashed()
 */
	class EmployeeStatus extends \Eloquent {}
}

namespace App{
/**
 * App\VisaEntry
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property int|null $number_of_entries
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\VisaEntry onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereNumberOfEntries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaEntry whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VisaEntry withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\VisaEntry withoutTrashed()
 */
	class VisaEntry extends \Eloquent {}
}

namespace App{
/**
 * App\RoomType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Room[] $rooms
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\RoomType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoomType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoomType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\RoomType withoutTrashed()
 */
	class RoomType extends \Eloquent {}
}

namespace App{
/**
 * App\PortalBaseModel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PortalBaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PortalBaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PortalBaseModel query()
 */
	class PortalBaseModel extends \Eloquent {}
}

namespace App{
/**
 * App\Country
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $country_code
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUuid($value)
 */
	class Country extends \Eloquent {}
}

namespace App{
/**
 * App\Address
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $person_id
 * @property int|null $country_id
 * @property int|null $address_type_id
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $city
 * @property string|null $province
 * @property string|null $postal_code
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\AddressType|null $addressType
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Country|null $country
 * @property-read \App\User|null $createdBy
 * @property-read \App\Person|null $person
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereAddressTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Address withoutTrashed()
 */
	class Address extends \Eloquent {}
}

namespace App{
/**
 * App\PersonType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Person[] $persons
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PersonType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PersonType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PersonType withoutTrashed()
 */
	class PersonType extends \Eloquent {}
}

namespace App{
/**
 * App\Guardian
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $family_id
 * @property int|null $person_id
 * @property int|null $guardian_type_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\Family|null $family
 * @property-read mixed $legal_full_name
 * @property-read mixed $name
 * @property-read \App\Person|null $person
 * @property-read \App\GuardianType|null $type
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian hasFamily()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Guardian onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereGuardianTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guardian withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Guardian withoutTrashed()
 */
	class Guardian extends \Eloquent {}
}

namespace App{
/**
 * App\File
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $file_extension_id
 * @property string|null $path
 * @property string|null $size
 * @property string|null $name
 * @property string|null $public_name
 * @property string|null $driver
 * @property int|null $download_count
 * @property int|null $original_file_id
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\FileExtension $extension
 * @property-read \App\File $originalFile
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File emptySize()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFileExtensionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereOriginalFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File wherePublicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereType($extension_type)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\File withoutTrashed()
 */
	class File extends \Eloquent {}
}

namespace App{
/**
 * App\AttendanceType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $short_name
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $should_alert
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property bool|null $is_present
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereIsPresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereShouldAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceType withoutTrashed()
 */
	class AttendanceType extends \Eloquent {}
}

namespace App{
/**
 * App\Year
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $year_start
 * @property int|null $year_end
 * @property mixed $start_date
 * @property mixed $end_date
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read mixed $name
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year currentFuture()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Year onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereYearEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereYearStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Year withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Year withoutTrashed()
 */
	class Year extends \Eloquent {}
}

namespace App{
/**
 * App\Visa
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $passport_id
 * @property int|null $visa_type_id
 * @property int|null $image_file_id
 * @property int|null $is_active
 * @property string|null $number
 * @property mixed $issue_date
 * @property mixed $expiration_date
 * @property int|null $visa_entry_id
 * @property int|null $entry_duration
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\File|null $image
 * @property-read \App\User|null $updatedBy
 * @property-read \App\VisaEntry|null $visaEntry
 * @property-read \App\VisaType|null $visaType
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Visa onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereEntryDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereImageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa wherePassportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereVisaEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visa whereVisaTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Visa withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Visa withoutTrashed()
 */
	class Visa extends \Eloquent {}
}

namespace App{
/**
 * App\Family
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Guardian[] $guardians
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Family onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Family whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Family withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Family withoutTrashed()
 */
	class Family extends \Eloquent {}
}

namespace App{
/**
 * App\Room
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $number
 * @property string|null $description
 * @property int|null $room_type_id
 * @property int|null $building_id
 * @property string|null $phone_extension
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Building $building
 * @property-read \App\User|null $createdBy
 * @property-read mixed $building_number
 * @property-read \App\RoomType $type
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Room onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room wherePhoneExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereRoomTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Room withoutTrashed()
 */
	class Room extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $person_id
 * @property string|null $username
 * @property string|null $email
 * @property string|null $display_name
 * @property string|null $given_name
 * @property string|null $family_name
 * @property string|null $azure_id
 * @property int $thumbnail_file_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AdGroup[] $adGroups
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Person|null $person
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \App\File $thumbnail
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAzureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGivenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereThumbnailFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $ad_group_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \App\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereAdGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Person
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $title
 * @property string|null $family_name
 * @property string|null $given_name
 * @property string|null $preferred_name
 * @property string|null $name_in_chinese
 * @property string|null $gender
 * @property mixed $dob
 * @property string|null $email_school
 * @property string|null $email_primary
 * @property string|null $email_secondary
 * @property int|null $image_file_id
 * @property string|null $website
 * @property int|null $person_type_id
 * @property int|null $language_primary_id
 * @property int|null $language_secondary_id
 * @property int|null $language_tertiary_id
 * @property int|null $country_of_birth_id
 * @property int|null $ethnicity_id
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\Employee $employee
 * @property-read \App\Ethnicity|null $ethnicity
 * @property-read mixed $age
 * @property-read \App\Guardian $guardian
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IdCard[] $idCards
 * @property-read \App\File $image
 * @property-read \App\Country|null $nationality
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OfficialDocument[] $officialDocuments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Passport[] $passports
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Phone[] $phones
 * @property-read \App\Language|null $primaryLanguage
 * @property-read \App\Language|null $secondaryLanguage
 * @property-read \App\Student $student
 * @property-read \App\Language|null $tertiaryLanguage
 * @property-read \App\User|null $updatedBy
 * @property-read \App\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Person onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereCountryOfBirthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereEmailPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereEmailSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereEmailSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereEthnicityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereGivenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereImageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereLanguagePrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereLanguageSecondaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereLanguageTertiaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereNameInChinese($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person wherePersonTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person wherePreferredName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Person withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Person withoutTrashed()
 */
	class Person extends \Eloquent {}
}

namespace App{
/**
 * App\Passport
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $person_id
 * @property int|null $country_id
 * @property int|null $image_file_id
 * @property int|null $is_active
 * @property string|null $family_name
 * @property string|null $given_name
 * @property string|null $number
 * @property mixed $issue_date
 * @property mixed $expiration_date
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Country|null $country
 * @property-read \App\User|null $createdBy
 * @property-read \App\File|null $image
 * @property-read \App\Person|null $person
 * @property-read \App\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Visa[] $visas
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Passport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereGivenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereImageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Passport whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Passport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Passport withoutTrashed()
 */
	class Passport extends \Eloquent {}
}

namespace App{
/**
 * App\OfficialDocument
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $official_document_type_id
 * @property int|null $person_id
 * @property int|null $file_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\File|null $file
 * @property-read \App\OfficialDocumentType|null $officialDocumentType
 * @property-read \App\Person|null $person
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\OfficialDocument onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereOfficialDocumentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocument whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OfficialDocument withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\OfficialDocument withoutTrashed()
 */
	class OfficialDocument extends \Eloquent {}
}

namespace App{
/**
 * App\StudentStatus
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\StudentStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentStatus whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StudentStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\StudentStatus withoutTrashed()
 */
	class StudentStatus extends \Eloquent {}
}

namespace App{
/**
 * App\Student
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $person_id
 * @property int|null $family_id
 * @property int|null $student_status_id
 * @property int|null $grade_level_id
 * @property mixed $start_date
 * @property mixed $end_date
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $username
 * @property string|null $password
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AttendanceDay[] $dailyAttendance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AttendanceClass[] $dailyClassAttendance
 * @property-read \App\Family|null $family
 * @property-read mixed $classes
 * @property-read mixed $email
 * @property-read string $formal_name
 * @property-read mixed $full_name
 * @property-read mixed $legal_full_name
 * @property-read mixed $name
 * @property-read \App\GradeLevel|null $gradeLevel
 * @property-read \App\Person|null $person
 * @property-read \App\StudentStatus|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AttendanceClass[] $todaysClassAttendance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AttendanceDay[] $todaysDailyAttendance
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student current()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student former()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student grade($grade_short_name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student graduated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student hasFamily()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student incoming()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student perspective()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereGradeLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereStudentStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Student withoutTrashed()
 */
	class Student extends \Eloquent {}
}

namespace App{
/**
 * App\Quarter
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property int|null $year_id
 * @property mixed $start_date
 * @property mixed $end_date
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @property-read \App\Year|null $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter current()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Quarter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quarter whereYearId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quarter withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Quarter withoutTrashed()
 */
	class Quarter extends \Eloquent {}
}

namespace App{
/**
 * App\AdGroup
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $azure_id
 * @property string|null $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AdGroup[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AdGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereAzureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdGroup whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AdGroup withoutTrashed()
 */
	class AdGroup extends \Eloquent {}
}

namespace App{
/**
 * App\Building
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $short_name
 * @property string|null $name
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Room[] $rooms
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Building onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Building whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Building withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Building withoutTrashed()
 */
	class Building extends \Eloquent {}
}

namespace App{
/**
 * App\GradeScale
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $is_percentage_based
 * @property bool|null $is_standards_based
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereIsPercentageBased($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereIsStandardsBased($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GradeScale whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GradeScale withoutTrashed()
 */
	class GradeScale extends \Eloquent {}
}

namespace App{
/**
 * App\FileExtension
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $mime_apache
 * @property string|null $mime_nginx
 * @property string|null $description
 * @property string|null $type
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension extensionsByType($type)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\FileExtension onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereMimeApache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereMimeNginx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileExtension whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileExtension withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\FileExtension withoutTrashed()
 */
	class FileExtension extends \Eloquent {}
}

namespace App{
/**
 * App\AttendanceClass
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $date
 * @property int|null $student_id
 * @property int|null $class_id
 * @property int|null $attendance_type_id
 * @property int|null $quarter_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \App\CourseClass|null $class
 * @property-read \App\User|null $createdBy
 * @property-read \App\Student|null $student
 * @property-read \App\AttendanceType|null $type
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass absent()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceClass onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass present()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereAttendanceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereQuarterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AttendanceClass whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceClass withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AttendanceClass withoutTrashed()
 */
	class AttendanceClass extends \Eloquent {}
}

namespace App{
/**
 * App\Course
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property string|null $short_name
 * @property string|null $credits
 * @property string|null $required_materials
 * @property int|null $max_class_size
 * @property bool|null $is_active
 * @property bool|null $has_attendance
 * @property bool|null $show_on_report_card
 * @property bool|null $calculate_report_card
 * @property bool|null $calculate_on_transcript
 * @property int|null $course_transcript_type_id
 * @property int|null $course_type_id
 * @property int|null $grade_scale_id
 * @property int|null $department_id
 * @property int|null $year_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseClass[] $classes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $corequisites
 * @property-read \App\User|null $createdBy
 * @property-read \App\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $equivalents
 * @property-read mixed $display_inline_corequisites
 * @property-read mixed $display_inline_equivalents
 * @property-read mixed $display_inline_grade_levels
 * @property-read mixed $display_inline_prerequisites
 * @property-read mixed $full_name
 * @property-read mixed $short_name_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GradeLevel[] $gradeLevels
 * @property-read \App\GradeScale $gradeScale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $prerequisites
 * @property-read \App\CourseTranscriptType $transcriptType
 * @property-read \App\CourseType $type
 * @property-read \App\User|null $updatedBy
 * @property-read \App\Year $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course current()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course gradeLevel($grades)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course hasAttendance()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course homeroom()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCalculateOnTranscript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCalculateReportCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCourseTranscriptTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCourseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereGradeScaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereHasAttendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereMaxClassSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereRequiredMaterials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereShowOnReportCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereYearId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Course withoutTrashed()
 */
	class Course extends \Eloquent {}
}

namespace App{
/**
 * App\Employee
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $person_id
 * @property int|null $employee_classification_id
 * @property int|null $employee_status_id
 * @property mixed $start_date
 * @property mixed $end_date
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\EmployeeClassification|null $classification
 * @property-read \App\User|null $createdBy
 * @property-read mixed $full_name
 * @property-read mixed $legal_full_name
 * @property-read mixed $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Person|null $person
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Position[] $positions
 * @property-read \App\EmployeeStatus|null $status
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereEmployeeClassificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereEmployeeStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace App{
/**
 * App\Department
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Department onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Department withoutTrashed()
 */
	class Department extends \Eloquent {}
}

namespace App{
/**
 * App\CourseType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\CourseType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\CourseType withoutTrashed()
 */
	class CourseType extends \Eloquent {}
}

namespace App{
/**
 * App\SchoolArea
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolArea onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SchoolArea whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolArea withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolArea withoutTrashed()
 */
	class SchoolArea extends \Eloquent {}
}

namespace App{
/**
 * App\ClassStatus
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseClass[] $classes
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ClassStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClassStatus whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClassStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ClassStatus withoutTrashed()
 */
	class ClassStatus extends \Eloquent {}
}

namespace App{
/**
 * App\AddressType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AddressType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AddressType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AddressType withoutTrashed()
 */
	class AddressType extends \Eloquent {}
}

namespace App{
/**
 * App\Language
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereUuid($value)
 */
	class Language extends \Eloquent {}
}

namespace App{
/**
 * App\OfficialDocumentType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $person_type_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\PersonType|null $personType
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\OfficialDocumentType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType wherePersonTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfficialDocumentType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OfficialDocumentType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\OfficialDocumentType withoutTrashed()
 */
	class OfficialDocumentType extends \Eloquent {}
}

namespace App{
/**
 * App\Phone
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $country_id
 * @property int|null $person_id
 * @property int|null $phone_type_id
 * @property string|null $number
 * @property string|null $extension
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Country|null $country
 * @property-read \App\User|null $createdBy
 * @property-read \App\Person|null $person
 * @property-read \App\PhoneType|null $phoneType
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Phone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone wherePhoneTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Phone withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Phone withoutTrashed()
 */
	class Phone extends \Eloquent {}
}

namespace App{
/**
 * App\CourseClass
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property int|null $course_id
 * @property int|null $primary_employee_id
 * @property int|null $secondary_employee_id
 * @property int|null $ta_employee_id
 * @property int|null $room_id
 * @property int|null $year_id
 * @property int|null $class_status_id
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AttendanceClass[] $attendance
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Course|null $course
 * @property-read \App\User|null $createdBy
 * @property-read mixed $full_name
 * @property-read mixed $students
 * @property-read \App\Employee|null $primaryEmployee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $q1Students
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $q2Students
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $q3Students
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $q4Students
 * @property-read \App\Room|null $room
 * @property-read \App\Employee|null $secondaryEmployee
 * @property-read \App\ClassStatus|null $status
 * @property-read \App\Employee|null $taEmployee
 * @property-read \App\User|null $updatedBy
 * @property-read \App\Year|null $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass active()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\CourseClass onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereClassStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass wherePrimaryEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereSecondaryEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereTaEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseClass whereYearId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseClass withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\CourseClass withoutTrashed()
 */
	class CourseClass extends \Eloquent {}
}

namespace App{
/**
 * App\Ethnicity
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ethnicity whereUuid($value)
 */
	class Ethnicity extends \Eloquent {}
}

namespace App{
/**
 * App\VisaType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property string|null $residency
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read mixed $formatted_name
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\VisaType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereResidency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisaType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VisaType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\VisaType withoutTrashed()
 */
	class VisaType extends \Eloquent {}
}

namespace App{
/**
 * App\GuardianType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Guardian[] $guardians
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\GuardianType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuardianType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GuardianType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GuardianType withoutTrashed()
 */
	class GuardianType extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property bool|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \App\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\ReportCardWeight
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $course_id
 * @property int|null $term
 * @property int|null $semester
 * @property int|null $final
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportCardWeight whereUuid($value)
 */
	class ReportCardWeight extends \Eloquent {}
}

namespace App{
/**
 * App\EmployeeBonusType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $amount
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeBonusType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmployeeBonusType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeBonusType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeBonusType withoutTrashed()
 */
	class EmployeeBonusType extends \Eloquent {}
}

namespace App{
/**
 * App\CourseTranscriptType
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_created_id
 * @property string|null $user_created_ip
 * @property string|null $user_updated_ip
 * @property int|null $user_updated_id
 * @property int|null $is_protected
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @property-read \App\User|null $createdBy
 * @property-read \App\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTranscriptType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereIsProtected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereUserCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereUserCreatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereUserUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereUserUpdatedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseTranscriptType whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTranscriptType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTranscriptType withoutTrashed()
 */
	class CourseTranscriptType extends \Eloquent {}
}


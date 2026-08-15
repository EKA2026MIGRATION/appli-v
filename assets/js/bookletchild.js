/**
 *
 */
class BookletChild {

    constructor(data) {
        this.childName          = data.child.fullname;
        this.childBirthdate     = data.child.birthdate;
        this.childAge           = data.child.age;
        this.childPhotoUrl      = "https://appli-v.net/"+data.child.photo;
        this.sportifProfil      = data.child.sportifProfil;
        this.guidingEye         = data.child.guidingEye;
        this.childHand          = data.child.childHand;
        this.childFoot          = data.child.childFoot;
        this.staffName          = data.staff.fullname;
        this.staffFirstname     = data.staff.person.firstname;
        this.staffPhotoUrl      = "https://appli-v.net/"+data.staff.person.photo;
        this.bookletName        = data.booklet.name;
        this.bookletDescription = data.booklet.description;
        this.dateEvaluation     = data.dateEvaluation;
        this.dateEvaluationFr   = data.dateEvaluationFr;
        this.comment            = data.comment;
    }
}
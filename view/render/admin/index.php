Requêtes maintenance
<br/>
<br/>
<ul>
  <li>
    <h3>MySql</h3>
    <ul>
      <li>
        <h4>Check links user/person/staff</h4>
        <ul>
          <li>
            <h5>vérifier les liasons user - person - staff</h5>

            SELECT u.id, u.email, p.person_id, p.firstname, p.lastname, s.staff_id FROM user u <br/>
            LEFT JOIN user_person_link l ON u.id = l.user_id<br/>
            LEFT JOIN person p ON l.person_id = p.person_id<br/>
            LEFT JOIN staff s ON s.person_id = p.person_id<br/>
            WHERE ();

          </li>
          <li>
            <h5>vérifier les liasons user sans person</h5>

            SELECT u.id, u.email, l.user_person_link_id FROM user u <br/>
            LEFT JOIN user_person_link l ON u.id = l.user_id<br/>
            WHERE l.person_id is null<br/>
          </li>

          <li>
            <h5>Rechercher la personne et le staff associé depuis le prénom et le nom</h5>

            SELECT p.person_id, p.firstname, p.lastname, s.staff_id FROM person p <br/>
            LEFT JOIN staff s ON p.person_id = s.person_id <br/>
            WHERE p.firstname like "Thomas" AND p.lastname = "Blanchard"; <br/>
          </li>

          <li>
            <h5>Mettre à jour les associations user - person</h5>

            INSERT INTO user_person_link SET user_id = 9551 , person_id = 28;
          </li>


        </ul>
      </li>
    </ul>
  </li>
</ul>

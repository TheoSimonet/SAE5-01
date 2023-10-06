import React, {useState, useEffect} from 'react';
import {fetchSemesters, fetchUsers} from '../services/api';
import {Link} from 'wouter';
import "../../styles/semesterList.css"
function Semesterlist() {
    const [semesters, setSemesters] = useState(null);

    useEffect(() => {
        fetchSemesters().then((data) => {
            setSemesters(data["hydra:member"]);
        });
    }, []);

    return (
        <div className={"semesterList"}>
            {semesters === null ? 'Loading...' :
                semesters.map((semester) => (
                    <div key={semester.id}>
                        <Link
                            href={
                                window.location.pathname.startsWith("/react/semesters/admin")
                                    ? `/react/semesters/admin/${semester.id}`
                                    : `/react/semesters/${semester.id}`
                            }
                        >
                            {semester.name}
                        </Link>
                    </div>
                ))
            }
        </div>
    );
}

export default Semesterlist;

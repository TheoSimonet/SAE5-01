import React, { useState, useEffect } from 'react';
import {getSemester, getMe, getSubject, getSubjectGroup, getSubjectTag} from '../services/api';
import { useRoute } from 'wouter';
import WishForm from './WishForm';
import "../../styles/semesterDetail.css"

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');
    const [userData, setUserData] = useState(null);

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);
        });
        getMe().then((userData) => {
            setUserData(userData);
        });
    }, [params.id]);



    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div className={"subjectList"}>
                    <ul>
                        {semester.subjects.map((subject) => {
                            const subjectId = subject['@id'].split('/').pop();
                            return (
                                <li key={subjectId} className="semester-li">
                                    <h2 className={"subjectName"}>{subject.subjectCode + ' - ' + subject.name}</h2>
                                    <br /><br />
                                    {(userData && userData.roles && userData.roles.includes("ROLE_ADMIN")) ? (
                                        <div>
                                            <p className="groupe">Groupes |</p>
                                            <div className="Postuler-container">
                                                <WishForm subjectId={`/api/subjects/${subjectId}`} />
                                            </div>
                                        </div>
                                    ) : null}

                                    {/*
                                        {subject.tag.map(async (tag) => {
                                            const tagData = await getSubjectTag(tag.split('/').pop());
                                            return (
                                                <div>{tagData.name}</div>
                                            );
                                        })}
                                    */}


                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default Semester;

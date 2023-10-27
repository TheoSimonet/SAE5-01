import React, { useState, useEffect } from 'react';
import {getSemester, fetchNbGroup, fetchGroups, getMe} from '../services/api';
import { useRoute } from 'wouter';
import WishForm from './WishForm';
import "../../styles/semesterDetail.css"
import NbGroups from "./NbGroups";

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');
    const [userData, setUserData] = useState(null);
    const [groups, setGroups] = useState([]);
    const [nbGroups, setNbGroups] = useState([]);
    const [subjects, setSubjects] = useState([]);

    useEffect(() => {
        (async () => {
            setGroups(await fetchGroups())

            // Récupérer les groupes
            const groupData = await fetchNbGroup();
            if (Array.isArray(groupData['hydra:member'])) {
                setNbGroups(groupData['hydra:member']);
            } else if (Array.isArray(groupData.nbGroups)) {
                setNbGroups(groupData.nbGroups);
            } else {
                console.error("Data from API is not an array:", groupData);
            }
        })()
    }, []);

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
                                <li key={subject['@id']} className="semester-li">
                                    <h2 className={"subjectName"}>{subject.subjectCode + ' - ' + subject.name}</h2>
                                    <br /><br />
                                    {(userData && userData.roles && userData.roles.includes("ROLE_ADMIN")) ? (
                                        <div>
                                            <div className="groupe-container">
                                                {groups === null ? 'Aucun Groupe Trouvé' : (
                                                    groups.filter((group) => group.subject === subject['@id'])
                                                        .map((group) => (
                                                            <ul key={group.id}>
                                                                <li className="groups">
                                                                    {group.type}
                                                                    <NbGroups nbGroups={nbGroups} group={group} />
                                                                </li>
                                                            </ul>
                                                        ))
                                                )}
                                            </div>
                                            <div className="Postuler-container">
                                                <WishForm subjectId={`/api/subjects/${subjectId}`} />
                                            </div>
                                        </div>
                                    ) : null}
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

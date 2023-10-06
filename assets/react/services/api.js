export const BASE_URL = '/api';

export function fetchSemesters() {
    return fetch(`${BASE_URL}/semesters`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}

export function getSemester(id) {
    return fetch(`${BASE_URL}/semesters/${id}`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}
export function fetchGroups() {
    return fetch(`${BASE_URL}/groups`)
        .then((response) => (response.ok ? response.json() : Promise.resolve(null)));
}

export function getGroup(id) {
    return fetch(`${BASE_URL}/groups/${id}`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}

export function postWish(subjectId, formData) {
    const url = `${BASE_URL}/wishes`;

    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Erreur lors de la soumission du voeu');
            }
            return response.json();
        })
        .catch((error) => {
            throw error;
        });
}

export function fetchGroupTypes() {
    return fetch(`${BASE_URL}/groups`)
        .then((response) => {
            if (!response.ok) {
                throw new Error('La récupération des types de groupe a échoué');
            }
            return response.json();
        })
        .then((data) => {
            if (Array.isArray(data)) {
                return data.map((item) => item.type);
            } else {
                throw new Error('Les données des types de groupe ne sont pas au format attendu');
            }
        })
        .catch((error) => {
            console.error('Erreur lors de la récupération des types de groupe :', error);
            throw error;
        });
}



export function getMe()
{
    return fetch(`${BASE_URL}/me`, {credentials: "include"}).then((response) => {
        if (response.ok) {
            return response.json();
        } else if (response.status === 401) {
            return Promise.resolve(null);
        }});
}


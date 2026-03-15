import { createContext, useEffect, useState } from "react";
import axios from "axios";
import api from "@/lib/axios.js";
import { toast } from "sonner";

export const MailContext = createContext(null);

export function MailProvider({ children }) {
    const [mailCards, setMailCards] = useState([]);
    const [selectedMail, setSelectedMail] = useState("");
    const [loading, setLoading] = useState(false);
    const [filters, setFilters] = useState([]);
    const [searchTerm, setSearchTerm] = useState("");
    const [activeScopeFilter, setActiveScopeFilter] = useState(null);
    const [yearFilter, setYearFilter] = useState("");
    const [typeFilter, setTypeFilter] = useState(""); // 'entrada' or 'salida'

    const loadMailCards = async () => {
        try {
            setLoading(true);
            const res = await api.get("/api/pqrs");
            setMailCards(res.data.data);
        } catch (err) {
            toast.error(
                err?.response?.data?.message ||
                err.message ||
                "Error al hacer la peticion"
            );
            throw new Error("Error al hacer la peticion");
        } finally {
            setLoading(false);
        }
    };

    const toggleFilter = (type) => {
        setFilters((prev) =>
            prev.includes(type)
                ? prev.filter((t) => t !== type)
                : [...prev, type]
        );
    };

    const filteredMailCards = mailCards.filter((card) => {
        const matchesFilter =
            filters.length === 0 || filters.includes(card.request_type);
        const matchesSearch =
            searchTerm === "" ||
            card.affair?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.description?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.radicado?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.recipient?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.sender_name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.id?.toString().includes(searchTerm) ||
            card.request_type?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.email?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.document?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.document_type?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.response_status?.toLowerCase().includes(searchTerm.toLowerCase()) ||
            card.year?.toString().includes(searchTerm);

        let matchesScope = true;
        if (activeScopeFilter) {
            if (activeScopeFilter.type === 'sheet') {
                matchesScope = card.sheet_number_id === activeScopeFilter.id;
            } else if (activeScopeFilter.type === 'dependency') {
                matchesScope = card.dependency_id === activeScopeFilter.id;
            }
        }

        const matchesYear = yearFilter === "" || card.year?.toString() === yearFilter;
        const matchesType = typeFilter === "" || card.type === typeFilter;

        return matchesFilter && matchesSearch && matchesScope && matchesYear && matchesType;
    });

    useEffect(() => {
        loadMailCards();
    }, []);

    return (
        <MailContext.Provider
            value={{
                mailCards,
                filteredMailCards,
                setMailCards,
                selectedMail,
                setSelectedMail,
                loading,
                filters,
                toggleFilter,
                searchTerm,
                setSearchTerm,
                activeScopeFilter,
                setActiveScopeFilter,
                yearFilter,
                setYearFilter,
                typeFilter,
                setTypeFilter,
                reloadMailCards: loadMailCards,
            }}
        >
            {children}
        </MailContext.Provider>
    );
}

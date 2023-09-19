package main

import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"os"
	"sort"
	"strings"
)

var specialMoveTypes = map[string]bool{}

func init() {
	specialMoveTypes["Fire"] = true
	specialMoveTypes["Water"] = true
	specialMoveTypes["Electr"] = true
	specialMoveTypes["Grass"] = true
	specialMoveTypes["Ice"] = true
	specialMoveTypes["Psychc"] = true
	specialMoveTypes["Dragon"] = true
	specialMoveTypes["Dark"] = true
}

type Output map[string]Pokemon

type Pokemon struct {
	Id           int           `json:"id"`
	Name         string        `json:"name"`
	Evolutions   []Evolution   `json:"evolutions"`
	LearnedMoves []LearnedMove `json:"moves_levelup"`
	TMMoves      []Move        `json:"moves_tm"`
}

type Evolution struct {
	Method   string `json:"method"`
	Argument any    `json:"arg"`
	Species  any    `json:"species"`
}

type LearnedMove struct {
	Level int  `json:"level"`
	Move  Move `json:"move"`
}

type Move struct {
	Name     string `json:"name"`
	Type     string `json:"type"`
	Accuracy int    `json:"accuracy"`
	Power    int    `json:"power"`
	PP       int    `json:"pp"`
	TM       int    `json:"tm"`
}

func main() {
	output := load("20230918-pokemon.json")
	var pokemon []Pokemon
	for _, p := range output {
		if strings.Contains(p.Name, "?") {
			continue
		}
		pokemon = append(pokemon, p)
	}
	sort.Slice(pokemon, func(i, j int) bool { return pokemon[i].Id < pokemon[j].Id })

	fmt.Println("| | | | |")
	fmt.Println("|-|-|-|-|")
	for i := 0; i < len(pokemon); i += 4 {
		p1, p2, p3, p4 := " ", " ", " ", " "
		p1 = printLink(pokemon[i])
		if i+1 < len(pokemon) {
			p2 = printLink(pokemon[i+1])
		}
		if i+2 < len(pokemon) {
			p3 = printLink(pokemon[i+2])
		}
		if i+3 < len(pokemon) {
			p4 = printLink(pokemon[i+3])
		}
		fmt.Printf("|%s|%s|%s|%s|\n", p1, p2, p3, p4)
	}
	fmt.Println()

	for _, p := range pokemon {
		fmt.Printf("## %s\n", p.Name)
		fmt.Printf("ID: %03d\n", p.Id)
		fmt.Println()
		if len(p.Evolutions) > 0 {
			fmt.Println("**Evolutions:**")
			fmt.Println("| Method | Evolution |")
			fmt.Println("|--------|-----------|")
			for _, e := range p.Evolutions {
				arg, _ := json.Marshal(e.Argument)
				species, ok := e.Species.(string)
				if !ok {
					bytes, _ := json.Marshal(e.Species)
					species = string(bytes)
				}
				fmt.Printf("|%s %s|[%s](#%s)|\n", e.Method, string(arg), species, anchor(species))
			}
			fmt.Println()
		}
		if len(p.LearnedMoves) > 0 {
			fmt.Println("**Learned Moves:**")
			fmt.Println("|Level|Move|Type|Power|Ac	curacy|PP|")
			fmt.Println("|-|-|-|-|-|-|")
			for _, lm := range p.LearnedMoves {
				fmt.Printf("|%d|%s|%s *(%s)*|%d|%d|%d|\n",
					lm.Level,
					lm.Move.Name, normalizeMoveType(lm.Move.Type), getCombatType(lm.Move.Type),
					lm.Move.Power, lm.Move.Accuracy, lm.Move.PP)
			}
			fmt.Println()
		}
		if len(p.TMMoves) > 0 {
			fmt.Println("**Compatible TM Moves:**")
			fmt.Println("|TM|Move|Type|Power|Accuracy|PP|")
			fmt.Println("|-|-|-|-|-|-|")
			for _, m := range p.TMMoves {
				fmt.Printf("|%s|%s|%s *(%s)*|%d|%d|%d|\n",
					getTM(m.TM),
					m.Name, normalizeMoveType(m.Type), getCombatType(m.Type),
					m.Power, m.Accuracy, m.PP)
			}
			fmt.Println()
		}
	}
}

func printLink(p Pokemon) string {
	return fmt.Sprintf("[%03d - %s](#%s)", p.Id, p.Name, anchor(p.Name))
}

func anchor(n string) string {
	return strings.ReplaceAll(strings.ToLower(n), " ", "-")
}

func getTM(i int) string {
	if i > 50 {
		return fmt.Sprintf("HM%02d", i-50)
	}
	return fmt.Sprintf("TM%02d", i)
}

func normalizeMoveType(t string) string {
	if t == "Electr" {
		return "Electric"
	}
	if t == "Psychc" {
		return "Psychic"
	}
	return t
}

func getCombatType(t string) string {
	if specialMoveTypes[t] {
		return "Special"
	}
	return "Physical"
}

func load(n string) Output {
	f, err := os.Open(n)
	if err != nil {
		fmt.Print(err)
		os.Exit(1)
	}
	bytes, err := ioutil.ReadAll(f)
	if err != nil {
		fmt.Print(err)
		os.Exit(1)
	}
	var output Output
	err = json.Unmarshal(bytes, &output)
	if err != nil {
		fmt.Print(err)
		os.Exit(1)
	}
	return output
}

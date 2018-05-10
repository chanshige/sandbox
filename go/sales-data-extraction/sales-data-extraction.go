package main

import (
"fmt"
"flag"
"os"
"path/filepath"
"bytes"
)

func main() {
	flag.Parse()
	err := validate(flag.Args())
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}

	filepath.Walk(flag.Arg(0), walkFunc)
}

func validate(args []string) error {
	if flag.NArg() < 2 {
		return fmt.Errorf("you must specify a sales data dir and date")
	}

	_, err := os.Stat(args[0])
	if os.IsNotExist(err) {
		return fmt.Errorf("specified directory does not exist")
	}

	return nil
}

func walkFunc(path string, info os.FileInfo, err error) error {
	// ディレクトリパスは不要
	if info.IsDir() {
		return nil
	}

	var point = false
	point, _ = filepath.Match(buildFilename("ECSaleData_"), filepath.Base(path))

	if point {
		fmt.Println(filepath.Base(path))
	}

	if err != nil {
		os.Exit(1)
	}

	return nil
}

func buildFilename(s string) string {
	var buffer bytes.Buffer
	buffer.WriteString(s)
	buffer.WriteString(flag.Arg(1))
	buffer.WriteString("*")

	return buffer.String()
}
